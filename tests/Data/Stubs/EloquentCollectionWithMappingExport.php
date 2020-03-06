<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Database\Eloquent\Collection;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromCollection;
use Developergf\Excel\Concerns\WithMapping;
use Developergf\Excel\Tests\Data\Stubs\Database\User;

class EloquentCollectionWithMappingExport implements FromCollection, WithMapping
{
    use Exportable;

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect([
            new User([
                'firstname' => 'Patrick',
                'lastname'  => 'Brouwers',
            ]),
        ]);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->firstname,
            $user->lastname,
        ];
    }
}
