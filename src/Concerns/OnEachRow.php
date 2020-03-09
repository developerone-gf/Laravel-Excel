<?php

namespace Periplia\Sheet\Excel\Concerns;

use Periplia\Sheet\Excel\Row;

interface OnEachRow
{
    /**
     * @param Row $row
     */
    public function onRow(Row $row);
}
