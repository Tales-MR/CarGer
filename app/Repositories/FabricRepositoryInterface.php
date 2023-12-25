<?php

namespace App\Repositories;

interface FabricRepositoryInterface
{
    public function createFabric($name);
    public function deleteFabric($idFabric);
    public function editFabric(array $data, $idFabric);
    public function getAllFabrics();
    public function getFabricBy($index, $by);
    public function checkExistingFabric($name);
}
