<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentOwnerRepository;
use App\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerCarController extends Controller
{
    private OwnerRepositoryInterface $ownerRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function store(Request $request): void
    {
        $data = $request->validate([
            'id_model'  => 'required|string',
            'id_owner'  => 'required|integer',
            'year'      => 'required|string'
        ]);

        $car = $this->ownerRepository->createCar($data);

        return;
    }

    public function edit(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function validateOwnerCar(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'id_owner'  => 'required|integer',
            'id_model'  => 'required|string',
            'year'      => 'required|string'
        ]);

        if ($this->ownerRepository->checkExistingOwnerCar($data['id_owner'], $data['id_model'], $data['year'])) {
            return response()->json([
                'code' => 0,
                'message' => 'O proprietário atual já possui um carro semelhante, deseja continuar?',
            ]);
        }

        return response()->json([
            'code' => 1,
        ]);
    }
}
