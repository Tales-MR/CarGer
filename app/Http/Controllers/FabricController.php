<?php

namespace App\Http\Controllers;

use App\Repositories\FabricRepositoryInterface;
use App\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FabricController extends Controller
{
    private FabricRepositoryInterface $fabricRepository;

    public function __construct(FabricRepositoryInterface $fabricRepository)
    {
        $this->fabricRepository = $fabricRepository;
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Fabric/ViewFabrics');
    }

    public function store(Request $request)
    {
        $name = $request->validate([
            'name' => 'required|string',
        ]);

        return $this->fabricRepository->createFabric($name);
    }

    public function edit(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function validateFabric(Request $request)
    {
        $name = $request->validate([
            'name' => 'required|string',
        ]);

        if ($this->fabricRepository->checkExistingFabric($name)) {

            return response()->json([
                'code' => 0,
                'message' => 'Fabricante já existente!',
            ]);
        }

        return response()->json([
            'code' => 1,
        ]);
    }
}
