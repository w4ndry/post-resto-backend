<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List categories
     */
    public function index()
    {
        try {

            $categories = Category::paginate(10);

            return response()->json([
                'status'    => 'success',
                'data'      => $categories,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Something went wrong',
            ]);
        }
    }
}
