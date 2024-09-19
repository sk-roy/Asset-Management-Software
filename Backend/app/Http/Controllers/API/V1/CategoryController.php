<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\API\V1\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getCategories();

            return response()->json([
                'Categories'=> $categories,
                'message'=> 'Categories loaded succesfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Categories loading failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Categories loading failed'], 500);
        }
    }

    public function store(Request $request)
    {
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

            return response()->json([
                'message' => 'Category created successfully', 
                'category' => $category
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating category:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create category'], 500);
        }
    }

    public function destroy($id)
    {
        try {            
            $task = Category::findOrFail($id);
            $this->categoryService->delete($id);
                
            return response()->json(['message' => 'Category deleted successfully.']);
        } catch (Exception $e) {            
            return response()->json(['message' => 'Request Failed.']);
        }
    }

    public function getFields($id)
    {
        try {
            $fields = $this->categoryService->getFields($id);

            return response()->json([
                'fields'=> $fields,
                'message'=> 'Fields loaded succesfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Fields loading failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Fields loading failed'], 500);
        }
    }
}
