<?php

namespace Developergf\Excel\Concerns;

use Illuminate\Support\Collection;

interface FromCollection
{
    /**
     * @return Collection
     */
    public function collection();
}
