<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Developergf\Excel\Concerns\Importable;
use Developergf\Excel\Concerns\WithEvents;
use Developergf\Excel\Events\AfterImport;
use Developergf\Excel\Events\AfterSheet;
use Developergf\Excel\Events\BeforeImport;
use Developergf\Excel\Events\BeforeSheet;

class ImportWithEvents implements WithEvents
{
    use Importable;

    /**
     * @var callable
     */
    public $beforeImport;

    /**
     * @var callable
     */
    public $beforeSheet;

    /**
     * @var callable
     */
    public $afterSheet;

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => $this->beforeImport ?? function () {
            },
            AfterImport::class => $this->afterImport ?? function () {
            },
            BeforeSheet::class => $this->beforeSheet ?? function () {
            },
            AfterSheet::class => $this->afterSheet ?? function () {
            },
        ];
    }
}
