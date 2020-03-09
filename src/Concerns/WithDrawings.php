<?php

namespace Periplia\Sheet\Excel\Concerns;

use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;

interface WithDrawings
{
    /**
     * @return BaseDrawing|BaseDrawing[]
     */
    public function drawings();
}
