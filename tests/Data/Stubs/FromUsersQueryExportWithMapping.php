<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Database\Query\Builder;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromQuery;
use Developergf\Excel\Concerns\WithEvents;
use Developergf\Excel\Concerns\WithMapping;
use Developergf\Excel\Events\BeforeSheet;
use Developergf\Excel\Tests\Data\Stubs\Database\User;

class FromUsersQueryExportWithMapping implements FromQuery, WithMapping, WithEvents
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return User::query();
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class   => function (BeforeSheet $event) {
                $event->sheet->chunkSize(10);
            },
        ];
    }

    /**
     * @param User $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            'name' => $row->name,
        ];
    }
}
