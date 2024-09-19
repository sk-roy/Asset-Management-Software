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
    public function store(Request $request) 
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'flat_number' => 'nullable|string',
                'floor_number' => 'nullable|string',
                'area' => 'nullable|numeric',
                'purchase_price' => 'nullable|numeric',
                'purchase_date' => 'nullable|date',
                'diagram_path' => 'nullable|string',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'brand' => 'nullable|string',
                'model' => 'nullable|string',
                'capacity' => 'nullable|numeric',
                'specification' => 'nullable|string',
                'plate_number' => 'nullable|string',
                'weight' => 'nullable|numeric',
                'category_id' => 'exists:categories,id',
            ]);
    
            $assetData = $request->only([
                'title', 'description', 'address', 'flat_number', 'floor_number', 'area',
                'purchase_price', 'purchase_date', 'diagram_path', 'latitude', 'longitude',
                'brand', 'model', 'capacity', 'specification', 'plate_number', 'weight'
            ]);
    
            $asset = $this->assetService->create(
                $assetData,
                auth()->id(),
                $request->input('category_id')
            );
    
            return response()->json(['message' => 'Asset created successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Asset creating failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Asset creation failed'], 500);
        }
    }
    
    
}
