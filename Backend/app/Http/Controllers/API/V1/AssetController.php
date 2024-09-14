<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\AssetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index(Request $request)
    {
        try {
            $userId = auth()->id();
            $sortKey = $request->input('sort_key', 'created_at');
            $sortOrder = $request->input('sort_order', 'asc');

            $assets = $this->assetService->loadSortedAssetsForUser($userId, $sortKey, $sortOrder);

            return response()->json([
                'assets'=> $assets,
                'message'=> 'Assets loaded succesfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Assets loading failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Assets loading failed'], 500);
        }
    }
    
}
