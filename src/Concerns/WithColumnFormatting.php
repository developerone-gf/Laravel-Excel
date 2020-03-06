<?php

namespace Developergf\Excel\Concerns;

interface WithColumnFormatting
{
    /**
     * @return array
     */
    public function columnFormats(): array;
}
