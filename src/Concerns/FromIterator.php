<?php

namespace Developergf\Excel\Concerns;

use Iterator;

interface FromIterator
{
    /**
     * @return Iterator
     */
    public function iterator(): Iterator;
}
