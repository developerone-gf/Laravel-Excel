<?php

namespace Developergf\Excel\Concerns;

use Developergf\Excel\Row;

interface OnEachRow
{
    /**
     * @param Row $row
     */
    public function onRow(Row $row);
}
