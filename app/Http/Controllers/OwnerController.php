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
        return Inertia::render('Owner');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $owner = $request->validate([
            'name'      => 'required|string',
            'birth'     => 'required|date',
            'gender'    => 'required|integer',
        ]);

        //Adicionando o proprietário ao banco de dados
        $owner = $this->ownerRepository->createOwner($owner);

        //Checande se um carro foi salvo junto
        $addCar = $request->validate([
            'addCar'    => 'boolean',
        ]);

        if ($addCar['addCar']) {
            $car = $request->validate([
                'fabric' => 'required|string',
                'model'  => 'required|string',
                'year'   => 'required|string'
            ]);

            $car = $this->ownerRepository->createCar($car, $this->ownerRepository->getLastIdOwner());
        }

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

    public function cardOwner()
    {

    }
}


