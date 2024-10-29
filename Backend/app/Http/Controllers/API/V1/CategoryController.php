<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\API\V1\ICategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        Log::info('Get Category [index] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $categories = $this->categoryService->getCategories($request->query('type'));
            
            $response['success'] = true;
            $response['data'] = $categories;
            $response['message'] = 'Categories loaded succesfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            Log::error('Categories loading failed:', ['error' => $e->getMessage()]);            
            $response['success'] = false;
            $response['message'] = 'Categories loading Failed.';
        }

        Log::info('Get Category [index] completed', ['response' => $response]);
        return response()->json($response);
    }

    public function store(Request $request)
    {
        Log::info('Create Category [store] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $request->validate([
                'name' => 'required|string|unique:categories,name',
                'title' => 'nullable|string', 
                'type' => 'required|in:Asset,Event',
                'fields' => 'nullable|array'
            ]);

            $category = $this->categoryService->create(
                $request->only(['name', 'title', 'type']), 
                auth()->id(),
                $request->input('fields')
            );
            
            $response['success'] = true;
            $response['data'] = $category;
            $response['message'] = 'Categories created succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (\Exception $e) {
            Log::error('Creating category failed:', ['error' => $e->getMessage()]);         
            $response['success'] = false;
            $response['message'] = 'Creating category failed.';
        }

        Log::info('Create Category [store] completed', ['response' => $response]);
        return response()->json($response);
    }

    public function destroy($id)
    {
        Log::info('Deleting Category [destroy] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {            
            $task = Category::findOrFail($id);
            $this->categoryService->softDelete($id);
            
            $response['success'] = true;
            $response['message'] = 'Category deleted succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (Exception $e) {               
            $response['success'] = false;
            $response['message'] = 'Deleting category Failed.';      
        }

        Log::info('Deleting Category [destroy] completed', ['response' => $response]);
        return response()->json($response);
    }

    public function getFields($id)
    {
        Log::info('Get Category fields [getFields] started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $fields = $this->categoryService->getFields($id);
            
            $response['success'] = true;
            $response['data'] = $fields;
            $response['message'] = 'Categories loaded succesfully.';
            Log::info($response['message'], ['response' => $response]);
        } catch (\Exception $e) {
            Log::error('Category fields loading:', ['error' => $e->getMessage()]);         
            $response['success'] = false;
            $response['message'] = 'Category fields loading Failed.';
        }

        Log::info('Get Category fields [getFields] completed', ['response' => $response]);
        return response()->json($response);
    }
}
