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

    public function getLatestOwnersData($limit)
    {
        return Owner::query()
            ->orderBy('id_owner', 'desc')
            ->limit($limit)
            ->get();
    }


    public function getAllCarsOwner($idOwner)
    {
        return Car::query()
            ->orderBy('fabric')
            ->where('id_owner', $idOwner)
            ->get();
    }

    public function getOwnerById($idOwner)
    {
        return Owner::query()
            ->where('id_owner', $idOwner)
            ->get();
    }
}
