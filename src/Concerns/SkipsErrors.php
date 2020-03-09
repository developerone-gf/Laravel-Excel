<?php

namespace Periplia\Sheet\Excel\Concerns;

use Illuminate\Support\Collection;
use Periplia\Sheet\Excel\Validators\Failure;
use Throwable;

trait SkipsErrors
{
    /**
     * @var Failure[]
     */
    protected $errors = [];

    /**
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        $this->errors[] = $e;
    }

    /**
     * @return Throwable[]|Collection
     */
    public function errors(): Collection
    {
        return new Collection($this->errors);
    }
}
