<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromQuery;
use Developergf\Excel\Concerns\WithCustomChunkSize;
use Developergf\Excel\Concerns\WithMapping;
use Developergf\Excel\Tests\Data\Stubs\Database\Group;

class FromGroupUsersQueuedQueryExport implements FromQuery, WithCustomChunkSize, ShouldQueue, WithMapping
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return Group::first()->users();
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
        ];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
