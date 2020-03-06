<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Database\Query\Builder;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromQuery;
use Developergf\Excel\Concerns\WithCustomChunkSize;
use Developergf\Excel\Tests\Data\Stubs\Database\User;

class FromUsersQueryExport implements FromQuery, WithCustomChunkSize
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
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
