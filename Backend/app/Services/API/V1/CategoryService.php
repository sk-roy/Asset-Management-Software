<?php

namespace App\Services\API\V1;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function getCategories() 
    {        
        $categories = Category::all();
        return $categories;
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
