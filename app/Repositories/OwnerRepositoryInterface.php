<?php

namespace App\Repositories;

interface OwnerRepositoryInterface
{
    public function createOwner(array $data);
    public function createCar(array $data);
    public function deleteOwner($idOwner);
    public function deleteCarOwner(array $data, $idOwner);
    public function getLastIdOwner();
    public function checkExistingOwner($name, $birth);
    public function checkExistingOwnerCar($idOwner, $model, $year);
    public function getLatestOwnersData($limit);
    public function getAllCarsOwner($idOwner);
    public function getOwnerById($idOwner);
}
