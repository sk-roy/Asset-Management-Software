<?php

namespace App\Services\API\V1;

use App\Models\Category;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function create(array $data, $userId, array $fields = []) 
    {    
        try {    
            $category = Category::create($data);
            $category->user()->associate($userId);
            $category->save();

            foreach ($fields as $fieldId) {
                $field = Field::find($fieldId);
                $field->categories()->attach($category);
            }

            return $category;
        } catch (\Exception $e) {
            Log::error('Category creating failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Category creating failed.');
        }
    }

    public function softDelete($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
        } catch (\ModelNotFoundException $e) {
            Log::error('Category not found:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            // Log and return error
            Log::error('Category deletion failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Category deletion failed.'], 500);
        }
    }

    public function parmanentlyDelete($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->forceDelete();
        } catch (\ModelNotFoundException $e) {
            Log::error('Category not found:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            // Log and return error
            Log::error('Category deletion failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Category deletion failed.'], 500);
        }
    }

    public function getCategories($type) 
    {
        try {
            if ($type === "all")
                $categories = Category::all();
            else
                $categories = Category::where('type', $type)->get();
            return $categories;
        } catch (\Exception $e) {
            Log::error('Loading all categories failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Loading all categories failed.');
        }
    }

    public function getFields($id)
    {
        try {
            $category = Category::findOrFail($id);
            $fields = $category->fields()->get();
            return $fields;
        } catch (\Exception $e) {
            Log::error('Fields loading failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Fields loading failed.');
        }
    }
}
