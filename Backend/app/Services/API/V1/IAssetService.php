<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

interface IAssetService
{
    public function loadSortedAssetsForUser($userId, $sortKey = 'created_at', $sortOrder = 'asc');
    public function getAsset($id);
    public function getAssetNotes($id);
    public function create(array $data, $userId, $categoryId);
    public function update($assetId, array $data);
    public function delete($assetId);
    public function deleteAssets(array $list);
}
