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
        $car = $request->validate([
            'id_owner'  => 'required|integer',

            'model'     => 'required|string',
            'year'      => 'required|string'
        ]);

        $car = $this->ownerRepository->createCar($car);

        return;
    }

    public function validateOwnerCar(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'id_owner'  => 'required|integer',

            'model'     => 'required|string',
            'year'      => 'required|string'
        ]);

        if ($this->ownerRepository->checkExistingOwnerCar($data['id_owner'], $data['model'], $data['year'])) {
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
