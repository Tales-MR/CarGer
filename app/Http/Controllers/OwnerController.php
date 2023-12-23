<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Car;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        return Inertia::render('Owner');
    }

    public function store(Request $request)
    {
        $owner = $request->validate([
            'name'      => 'required|string',
            'birth'     => 'required|date',
            'gender'    => 'required|integer',
        ]);

        //Adicionando o proprietário ao banco de dados
        Owner::create($owner);

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

            $id_owner = Owner::max('id_owner');

            Car::create(
                array_merge($car, ['id_owner' => $id_owner])
            );
        }

        /*
        'fabric'      => 'required|string',
        'model'     => 'required|string',
        'year'      => 'required|string',
         */

        //Preciso checar se existe outro registro dessa pessoa no banco
    }
}
