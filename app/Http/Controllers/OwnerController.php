<?php

namespace App\Http\Controllers;

use App\Repositories\OwnerRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    //Provider criado para injeção de dependência
    private $ownerRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }
    public function index()
    {
        $latestFiveOwner = $this->ownerRepository->getLatestOwnersData(3);
        $data = [];

        foreach ($latestFiveOwner as $owner) {
            $ownerCar = $this->ownerRepository->getAllCarsOwner($owner['id_owner']);

            $data[] = [
                'owner' => $owner,
                'ownerCars' => $ownerCar,
                'qtdCars' => count($ownerCar),
            ];
        }

        return Inertia::render('Owner', ['data' => $data]);
    }


    public function store(Request $request)
    {
        $owner = $request->validate([
            'name'      => 'required|string',
            'birth'     => 'required|date',
            'gender'    => 'required|integer',
        ]);

        //Adicionando o proprietário ao banco de dados
        $owner = $this->ownerRepository->createOwner($owner);


        /*
        if ($addCar['addCar']) {
            $car = $request->validate([
                'fabric' => 'required|string',
                'model'  => 'required|string',
                'year'   => 'required|string'
            ]);

            $car = $this->ownerRepository->createCar($car, $this->ownerRepository->getLastIdOwner());
        }
        */

        return to_route('Owner');
    }

    public function validateOwner(Request $request)
    {
        $data = $request->validate([
           'name' => 'required|string',
           'birth' => 'required|date'
        ]);

        if ($this->ownerRepository->checkExistingOwner($data['name'], $data['birth'])) {
            return response()->json([
                'code' => 0,
                'message' => 'Já existe uma pessoa com esse nome e data de aniversário. Deseja continuar?',
            ]);
        }

        return response()->json([
           'code' => 1,
        ]);
    }

    public function getOwnerData(Request $request)
    {
        $data = $request->validate([
           'id_owner' => 'required|string'
        ]);

        return response()->json([
            'owner' => $this->ownerRepository->getOwnerById($data['id_owner']),
            'car' => $this->ownerRepository->getAllCarsOwner($data['id_owner'])
        ]);
    }
}


