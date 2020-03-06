<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\WithEvents;
use Developergf\Excel\Events\AfterSheet;
use Developergf\Excel\Events\BeforeExport;
use Developergf\Excel\Events\BeforeSheet;
use Developergf\Excel\Events\BeforeWriting;

class ExportWithEvents implements WithEvents
{
    use Exportable;

    /**
     * @var callable
     */
    public $beforeExport;

    /**
     * @var callable
     */
    public $beforeWriting;

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
            BeforeExport::class  => $this->beforeExport ?? function () {
            },
            BeforeWriting::class => $this->beforeWriting ?? function () {
            },
            BeforeSheet::class   => $this->beforeSheet ?? function () {
            },
            AfterSheet::class    => $this->afterSheet ?? function () {
            },
        ];
    }
}
