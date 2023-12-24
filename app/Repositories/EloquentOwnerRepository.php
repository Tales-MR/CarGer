<?php

namespace App\Repositories;

use App\Models\Fabric;
use App\Models\Owner;
use App\Models\Car;
use Illuminate\Support\Str;

class EloquentOwnerRepository implements OwnerRepositoryInterface
{
    public function createOwner(array $data): void
    {
        Owner::create($data);

        return;
    }

    public function createCar(array $data): void
    {
        Car::create($data);

        return;
    }


    public function deleteOwner($idOwner): \Illuminate\Http\JsonResponse
    {
        $owner = Owner::find($idOwner);

        if (!$owner) {
            return response()->json(['error' => 'Proprietário não encontrado'], 404);
        }

        $owner->delete();

        return response()->json(['message' => 'Proprietário excluído com sucesso']);
    }


    public function deleteCarOwner(array $data, $idOwner)
    {
        $car = Fabric::find($data)
            ->where('id_owner', $idOwner);

        if (!$car) {
            return response()->json(['error' => 'Carro não encontrado'], 404);
        }

        $car->delete();

        return response()->json(['message' => 'Carro excluído com sucesso']);
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


    public function checkExistingOwnerCar($idOwner, $model, $year)
    {
        $forModel = Str::upper($model);


        return Car::whereRaw("UPPER(id_model) = '{$forModel}'")
            ->whereRaw("year = '{$year}'")
            ->where('id_owner', $idOwner)
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
            ->orderBy('id_model')
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
