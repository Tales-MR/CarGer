<?php

namespace App\Repositories;

use App\Models\Fabric;
use App\Repositories\FabricRepositoryInterface;
use App\Models\Owner;
use App\Models\Car;
use Illuminate\Support\Str;

class EloquentFabricRepository implements FabricRepositoryInterface
{
    public function createFabric($name)
    {
        return Fabric::create(['name' => $name]);
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


    public function getFabricBy($index, $by): \Illuminate\Database\Eloquent\Collection|array
    {
        return Fabric::query()
            ->where($index, $by)
            ->get();
    }


    public function checkExistingFabric($name)
    {
        $forName = Str::upper($name);

        return Fabric::where('name', $forName)
            ->exists();
    }
}
