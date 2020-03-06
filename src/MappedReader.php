<?php

namespace Developergf\Excel;

use Illuminate\Support\Collection;
use Developergf\Excel\Concerns\ToArray;
use Developergf\Excel\Concerns\ToCollection;
use Developergf\Excel\Concerns\ToModel;
use Developergf\Excel\Concerns\WithCalculatedFormulas;
use Developergf\Excel\Concerns\WithMappedCells;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MappedReader
{
    /**
     * @param WithMappedCells $import
     * @param Worksheet       $worksheet
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function map(WithMappedCells $import, Worksheet $worksheet)
    {
        $mapped = [];
        foreach ($import->mapping() as $name => $coordinate) {
            $cell = Cell::make($worksheet, $coordinate);

            $mapped[$name] = $cell->getValue(
                null,
                $import instanceof WithCalculatedFormulas
            );
        }

        if ($import instanceof ToModel) {
            $model = $import->model($mapped);

            if ($model) {
                $model->saveOrFail();
            }
        }

        if ($import instanceof ToCollection) {
            $import->collection(new Collection($mapped));
        }

        if ($import instanceof ToArray) {
            $import->array($mapped);
        }
    }
}
