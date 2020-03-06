<?php

namespace Developergf\Excel\Concerns;

interface WithValidation
{
    /**
     * @return array
     */
    public function rules(): array;
}
