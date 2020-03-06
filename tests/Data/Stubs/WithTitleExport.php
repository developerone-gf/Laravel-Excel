<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\WithTitle;

class WithTitleExport implements WithTitle
{
    use Exportable;

    /**
     * @return string
     */
    public function title(): string
    {
        return 'given-title';
    }
}
