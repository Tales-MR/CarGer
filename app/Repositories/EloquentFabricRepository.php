<?php

namespace App\Repositories;

use App\Models\Fabric;
use App\Repositories\FabricRepositoryInterface;
use App\Models\Owner;
use App\Models\Car;
use Illuminate\Support\Str;

class EloquentFabricRepository implements FabricRepositoryInterface
{
    public function createFabric($data): void
    {
        Fabric::create($data);

        return;
    }


    public function deleteFabric($idFabric): \Illuminate\Http\JsonResponse
    {
        $fabric = Fabric::find($idFabric);

        if (!$fabric) {
            return response()->json(['error' => 'Fabricante não encontrado'], 404);
        }

        $fabric->delete();

        return response()->json(['message' => 'Fabricante excluído com sucesso']);
    }


    public function editFabric(array $data, $idFabric): \Illuminate\Http\JsonResponse
    {
        $fabric = Fabric::find($idFabric);

        if (!$fabric) {
            return response()->json(['error' => 'Fabricante não encontrado'], 404);
        }

        $fabric->update($data);

        return response()->json(['message' => 'Fabricante editado com sucesso']);
    }


    public function getAllFabrics(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Fabric::query()
            ->orderBy('name')
            ->get();
    }


    public function getFabricById($idFabric): \Illuminate\Database\Eloquent\Collection|array
    {
        return Fabric::query()
            ->orderBy('id_fabric')
            ->where('id_owner', $idOwner)
            ->get();
    }


    public function checkExistingFabric($name)
    {
        $forName = Str::upper($name['name']);

        return Fabric::whereRaw("UPPER(name) = '{$forName}'")
            ->exists();
    }
}
