<?php

namespace App\Services\API\V1;

interface IDocumentService
{
    public function getAll($getAll);
    public function create($assetId, $uploadedDocument);
    public function download($id);
    public function delete($id);
    public function restore($id);
}
