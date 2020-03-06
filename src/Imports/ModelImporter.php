<?php

namespace Developergf\Excel\Imports;

use Developergf\Excel\Concerns\ToModel;
use Developergf\Excel\Concerns\WithBatchInserts;
use Developergf\Excel\Concerns\WithCalculatedFormulas;
use Developergf\Excel\Concerns\WithMapping;
use Developergf\Excel\Concerns\WithProgressBar;
use Developergf\Excel\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ModelImporter
{
    /**
     * @var ModelManager
     */
    private $manager;

    /**
     * @param ModelManager $manager
     */
    public function __construct(ModelManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Worksheet $worksheet
     * @param ToModel   $import
     * @param int|null  $startRow
     */
    public function import(Worksheet $worksheet, ToModel $import, int $startRow = 1)
    {
        $headingRow       = HeadingRowExtractor::extract($worksheet, $import);
        $batchSize        = $import instanceof WithBatchInserts ? $import->batchSize() : 1;
        $endRow           = EndRowFinder::find($import, $startRow);
        $progessBar       = $import instanceof WithProgressBar;
        $withMapping      = $import instanceof WithMapping;
        $withCalcFormulas = $import instanceof WithCalculatedFormulas;

        $i = 0;
        foreach ($worksheet->getRowIterator($startRow, $endRow) as $spreadSheetRow) {
            $i++;

            $row      = new Row($spreadSheetRow, $headingRow);
            $rowArray = $row->toArray(null, $withCalcFormulas);

            if ($withMapping) {
                $rowArray = $import->map($rowArray);
            }

            $this->manager->add(
                $row->getIndex(),
                $rowArray
            );

            // Flush each batch.
            if (($i % $batchSize) === 0) {
                $this->manager->flush($import, $batchSize > 1);
                $i = 0;

                if ($progessBar) {
                    $import->getConsoleOutput()->progressAdvance($batchSize);
                }
            }
        }

        // Flush left-overs.
        $this->manager->flush($import, $batchSize > 1);
    }
}
