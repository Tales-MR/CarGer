<?php

namespace App\Repositories;

interface OwnerRepositoryInterface
{
    public function createOwner(array $data);
    public function createCar(array $data, $ownerId);
    public function getLastIdOwner();
    public function checkExistingOwner($name, $birth);
}
