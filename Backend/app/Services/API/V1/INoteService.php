<?php

namespace App\Services\API\V1;

interface INoteService
{
    public function get($id);
    public function getAll();
    public function create($userId, $assetId, array $data);
    public function update($id, array $data);
    public function delete($id);
}
