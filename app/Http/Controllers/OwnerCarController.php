<?php

namespace App\Http\Controllers;

use App\Repositories\EloquentOwnerRepository;
use App\Repositories\FabricRepositoryInterface;
use App\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerCarController extends Controller
{
    private OwnerRepositoryInterface $ownerRepository;
    private FabricRepositoryInterface $fabricRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository, FabricRepositoryInterface $fabricRepository)
    {
        $this->ownerRepository = $ownerRepository;
        $this->fabricRepository = $fabricRepository;
    }

    public function store(Request $request): void
    {
        $data = $request->validate([
            'model'  => 'required|string',
            'id_owner'  => 'required|integer',
            'year'      => 'required|string'
        ]);

        $idModel = $this->ownerRepository->getModelByName($data['model']);
        $car = $this->ownerRepository->createCar(array_merge($data, ['id_model' => $idModel[0]['id_model']]));

        return;
    }

    public function edit(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function validateOwnerCarModFab(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'id_owner'  => 'required|integer',
            'model'     => 'required|string',
            'fabric'    => 'required|string',
            'year'      => 'required|string'
        ]);

        if (!$this->ownerRepository->checkExistingModelCar($data['model'])
            && $this->fabricRepository->checkExistingFabric($data['fabric']))
        {
            $idFabric = $this->fabricRepository->getFabricBy('name', $data['fabric']);
            $modelCar = $this->ownerRepository->createModelCar(['model' => $data['model']], ['id_fabric' => $idFabric['id_fabric']]);

            if ($this->ownerRepository->checkExistingOwnerCar($data['id_owner'], $modelCar['id_model'], $data['year'])) {
                return response()->json([
                    'code' => 0,
                    'message' => 'O proprietário atual já possui um carro semelhante, deseja continuar?',
                ]);
            }
        }
        elseif (!$this->fabricRepository->checkExistingFabric($data['fabric']))
        {
            return response()->json([
                'code' => 1,
                'message' => 'O Fabricante informado não exite, gostaria de criá-lo e continuar?',
            ]);
        }

        return response()->json([
            'code' => 2,
            'message' => 'Carro registrado com sucesso!',
        ]);
    }

    public function validateStoreFabMod(Request $request): void
    {
        $data = $request->validate([
            'id_owner'  => 'required|integer',
            'model'     => 'required|string',
            'fabric'    => 'required|string',
            'year'      => 'required|string'
        ]);

        $fabric = $this->fabricRepository->createFabric($data['fabric']);
        $model = $this->ownerRepository->createModelCar($data['model'], $fabric['id']);
        $car = $this->ownerRepository->createCar(['data' => [$data, $model]]);
    }


    public function renderCarInfo($idCar, $model)
    {
          return Inertia::render('Owner/ViewCar', [
            'car' => $this->ownerRepository->getCarById($idCar),
            'model' => $this->ownerRepository->getModelByName($model),
        ]);
    }
}
