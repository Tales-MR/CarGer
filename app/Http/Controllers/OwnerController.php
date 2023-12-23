<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            'frab'      => 'required|string',
            'model'     => 'required|string',
            'year'      => 'required|string',
        ]);

        //Preciso checar se existe outro registro dessa pessoa no banco

    }
}
