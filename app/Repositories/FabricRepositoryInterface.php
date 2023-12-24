<?php

namespace App\Repositories;

interface FabricRepositoryInterface
{
    public function createFabric(array $data);
    public function deleteFabric($idFabric);
    public function editFabric(array $data, $idFabric);
    public function getAllFabrics();
    public function getFabricById($idFabric);
    public function checkExistingFabric($name);
}
