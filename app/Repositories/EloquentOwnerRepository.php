<?php

namespace App\Repositories;

use App\Models\Fabric;
use App\Models\Owner;
use App\Models\Car;
use Illuminate\Support\Str;

class EloquentOwnerRepository implements OwnerRepositoryInterface
{
    public function createOwner(array $data)
    {
        return Owner::create($data);
    }




    public function createCar(array $data)
    {
        return Car::create(array_merge($data, ['id_fabric' => 'Ford']));
    }




    public function createFabric(array $data)
    {
        return Fabric::create($data);
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




    public function deleteFabric($idFabric)
    {
        $fabric = Fabric::find($idFabric);

        if (!$fabric) {
            return response()->json(['error' => 'Fabricante não encontrado'], 404);
        }

        $fabric->delete();

        return response()->json(['message' => 'Fabricante excluído com sucesso']);
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


        return Car::whereRaw("UPPER(model) = '{$forModel}'")
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
            ->orderBy('id_fabric')
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
