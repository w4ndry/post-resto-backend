<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List products
     */
    public function index()
    {
        try {

            $products = Product::paginate(10);

            return response()->json([
                'status'    => 'success',
                'data'      => $products,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Something went wrong',
            ]);
        }
    }
}
