<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromQuery;
use Developergf\Excel\Concerns\WithCustomChunkSize;

class FromNonEloquentQueryExport implements FromQuery, WithCustomChunkSize
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return DB::table('users')->select('name')->orderBy('id');
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
