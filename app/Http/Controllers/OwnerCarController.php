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

    //Stages of validate new car

    public function validateStageOne(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'model'     => 'required|string',
            'fabric'    => 'required|string',
        ]);


        //Checando se a fabrica existe
        if (!$this->fabricRepository->checkExistingFabric($data['fabric']))
        {
            return response()->json([
                'code' => 1,
                'message' => 'O Fabricante não existe, deseja criá-lo?',
            ]);
        }

        $fabric = $this->fabricRepository->getFabricBy('name', $data['fabric'])[0];

        return response()->json([
            'code' => 2,
            'message' => 'O Fabricante existe!',
            'id_fabric' => $fabric['id_fabric']
        ]);
    }


    //Criando am fabrica
    public function validateStageTwo(Request $request)
    {
        $data = $request->validate([
           'fabric' => 'required|string'
        ]);

        $fabric = $this->fabricRepository->createFabric($data['fabric'])['id'];

        return response()->json([
            'code' => 2,
            'message' => 'O Fabricante existe!',
            'id_fabric' => $fabric
        ]);
    }


    //Verificando se o modelo existe
    public function validateStageThree(Request $request)
    {
        $data = $request->validate([
           'model' => 'required|string',
           'id_fabric' => 'required|integer'
        ]);

        $exists = $this->ownerRepository->checkExistingModelCar($data['model']);

        if (!$exists) {
            $model = $this->ownerRepository->createModelCar($data['model'], $data['id_fabric']);

            return response()->json([
               'code' => 3,
               'id_model' => $model['id']
            ]);
        }

        $existsInFab = $this->ownerRepository->getModelByName($data['model'])[0];

        //Verificar se a Fabrica atual é a mesma do modelo
        $fabricModel = $this->fabricRepository->getFabricBy('id_fabric', $existsInFab['id_fabric'])[0];

        if ($fabricModel['id_fabric'] !== $data['id_fabric']) {
            //Fabrica diferente

            return response()->json([
                'code' => 96,
                'message' => 'O Modelo escolhido já existe em outro Fabricante, deseja criá-lo também no Fabricante atual?',
                'id_model' => $existsInFab['id_model']
            ]);
        }

        //Fabrica de origem
        return response()->json([
            'code' => 3,
            'id_model' => $existsInFab['id_model']
        ]);
    }


    public function validateStageFour(Request $request)
    {
        $data = $request->validate([
            'id_owner' => 'required|integer',
            'id_model' => 'required|integer',
            'year'     => 'required|string'
        ]);

        //Checando se o owner já possui esse carro
        $exists = $this->ownerRepository->checkExistingOwnerCar($data['id_owner'], $data['id_model'], $data['year']);

        if ($exists) {
            return response()->json([
                'code' => 4,
                'message' => 'O Proprietário já possui o mesmo modelo de carro, deseja adicionar?',
                'id_owner' => $data['id_owner'],
                'id_model' => $data['id_model'],
                'year' => $data['year']
            ]);
        }

        return response()->json([
           'code' => 5,
            'id_owner' => $data['id_owner'],
            'id_model' => $data['id_model'],
            'year' => $data['year']
        ]);
    }

    public function validateStageStore(Request $request)
    {
       $data = $request->validate([
           'id_model'  => 'required|integer',
           'id_owner' => 'required|integer',
           'year'     => 'required|string',
       ]);

       $car = $this->ownerRepository->createCar($data);

       return response()->json([
           'code' => 10,
           'message' => 'Carro cadastrado com sucesso!'
       ]);
    }




    public function renderCarInfo($idCar, $model)
    {
          return Inertia::render('Owner/ViewCar', [
            'car' => $this->ownerRepository->getCarById($idCar),
            'model' => $this->ownerRepository->getModelByName($model),
        ]);
    }
}
