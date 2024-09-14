<?php

namespace App\Services\API\V1;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssetService
{
    public function loadSortedAssetsForUser($userId, $sortKey = 'created_at', $sortOrder = 'asc')
    {
        try {
            $validSortOrder = ['asc', 'desc'];
            if (!in_array(strtolower($sortOrder), $validSortOrder)) {
                $sortOrder = 'asc'; 
            }

            $user = User::findOrFail($userId);
            $assets = $user->assets()->orderBy($sortKey, $sortOrder)->get();

            return $assets;
        } catch (\Exception $e) {
            Log::error('Assets loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Assets loading failed.');
        }
    }
}
