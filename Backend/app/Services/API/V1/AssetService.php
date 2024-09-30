<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssetService implements IAssetService
{
    public function loadSortedAssetsForUser($userId, $sortKey = 'created_at', $sortOrder = 'asc')
    {
        Log::info('Method [AssetService.loadSortedAssetsForUser] Start.', 
            ['userId' => $userId, 'sortKey' => $sortKey, 'sortOrder' => $sortOrder]);
        $assets = [];

        try {
            $validSortOrder = ['asc', 'desc'];
            if (!in_array(strtolower($sortOrder), $validSortOrder)) {
                $sortOrder = 'asc'; 
            }

            $user = User::findOrFail($userId);
            $assets = $user->assets()->orderBy($sortKey, $sortOrder)->get();
            Log::error('Assets loading completed:', ['assets' => $assets, 'user' => $user]);

        } catch (\Exception $e) {
            Log::error('Assets loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Assets loading failed.');
        }
        
        Log::info('Method [AssetService.loadSortedAssetsForUser] End.',
            ['userId' => $userId, 'sortKey' => $sortKey, 'sortOrder' => $sortOrder]);
        return $assets;
    }

    public function getAsset($id)
    {
        Log::info('Method [AssetService.getAsset] Start.', ['id' => $id]);
        
        try {
            $asset = Asset::with(['notes', 'documents'])->find($id);

            if (!$asset) {
                Log::error('Asset not found:', ['error' => $e->getMessage()]);
                throw new \Exception('Asset not found.');
            }

            Log::info('Asset loading completed:', ['asset' => $asset]);

        } catch (Exception $e) {
            Log::error('Assets loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Assets loading failed.');
        }
        
        Log::info('Method [AssetService.getAsset] End.', ['asset' => $asset]);
        return $asset;
    }

    public function getAssetNotes($id)
    {
        Log::info('Method [AssetService.getAssetNotes] Start.', ['id' => $id]);
        
        try {
            $asset = Asset::findOrFail($id);
            $notes = $asset->notes()->get();
            Log::error('Asset loading completed:', ['asset' => $asset, 'notes' => $notes]);

        } catch (Exception $e) {
            Log::error('Assets loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Assets loading failed.');
        }
        
        Log::info('Method [AssetService.getAssetNotes] End.', ['asset' => $asset, 'notes' => $notes]);
        return $notes;
    }

    public function create(array $data, $userId, $categoryId)
    {
        Log::info('Method [AssetService.create] Start.', 
            ['userId' => $userId, 'data' => $data, 'categoryId' => $categoryId]);

        try {
            $asset = Asset::create($data);

            $user = User::find($userId);
            $category = Category::find($categoryId);

            $asset->user()->associate($user);
            $asset->category()->associate($category);
            $asset->save();
            Log::error('Asset created succesfully:', ['asset' => $asset, 'user' => $user]);

        } catch (Exception $e) {
            Log::error('Assets creating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while creating the asset", 500);
        }
        
        Log::info('Method [AssetService.create] End.',
            ['userId' => $userId, 'data' => $data, 'categoryId' => $categoryId]);
        return $asset;
    }

    public function update($assetId, array $data)
    {
        Log::info('Method [update] Start.', ['assetId' => $assetId, 'data' => $data]);

        try {
            $asset = Asset::find($assetId);
            $asset->update($data);
            Log::error('Asset updated succesfully:', ['asset' => $asset]);

        } catch (ModelNotFoundException $e) {            
            Log::error('Assets not found:', ['error' => $e->getMessage()]);
            throw new Exception("Asset not found", 404);
        } catch (Exception $e) {            
            Log::error('Assets updating failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while updating asset", 500);
        }
        
        Log::info('Method [AssetService.update] End.', ['asset' => $asset]);
        return $asset;
    }

    public function delete($assetId)
    {
        Log::info('Method [AssetService.delete] Start.', ['assetId' => $assetId]);

        try {
            $asset = Asset::find($assetId);
            $asset->delete();
            Log::info('Asset deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Assets not found:', ['error' => $e->getMessage()]);
            throw new Exception("Asset not found", 404);
        } catch (Exception $e) {            
            Log::error('Assets deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting asset", 500);
        }

        Log::info('Method [AssetService.delete] End.', ['assetId' => $assetId]);
    }

    public function deleteAssets(array $list)
    {
        Log::info('Method [AssetService.deleteAssets] Start.', ['list' => $list]);

        try {
            Asset::whereIn('id', $list)->delete();            
            Log::info('Assets deleted succesfully.');

        } catch (ModelNotFoundException $e) {            
            Log::error('Assets not found:', ['error' => $e->getMessage()]);
            throw new Exception("Assets not found", 404);
        } catch (Exception $e) {            
            Log::error('Assets deleting failed:', ['error' => $e->getMessage()]);
            throw new Exception("An error occurred while deleting assets", 500);
        }

        Log::info('Method [AssetService.deleteAssets] End.', ['list' => $list]);
    }
}
