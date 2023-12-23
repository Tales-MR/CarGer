<?php

namespace App\Repositories;

use App\Models\Owner;
use App\Models\Car;
use Illuminate\Support\Str;

class EloquentOwnerRepository implements OwnerRepositoryInterface
{
    public function createOwner(array $data)
    {
        return Owner::create($data);
    }

    public function createCar(array $data, $ownerId)
    {
        return Car::create(array_merge($data, [
            'id_owner' => $ownerId
        ]));
    }

    public function getLastIdOwner()
    {
        return Owner::max('id_owner');
    }

    public function checkExistingOwner($name, $birth)
    {
        $formattedName = Str::upper($name);

        return Owner::whereRaw("UPPER(name) = '{$formattedName}'")
        ->where('birth', $birth)
        ->exists();
    }
}
