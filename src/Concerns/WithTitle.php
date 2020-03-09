<?php

namespace Periplia\Sheet\Excel\Concerns;

interface WithTitle
{
    /**
     * @return string
     */
    public function title(): string;
}
