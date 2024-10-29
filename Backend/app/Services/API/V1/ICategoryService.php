<?php

namespace App\Services\API\V1;

interface ICategoryService
{
    public function create(array $data, $userId, array $fields = []); 
    public function softDelete($id);
    public function parmanentlyDelete($id);
    public function getCategories($type);
    public function getFields($id);
}
