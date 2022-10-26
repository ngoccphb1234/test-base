<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->paginate(5);
        $result = [];
        foreach ($products as $product){
            $result[] = $product;
        }
        $meta = get_meta($products);
        return restful_success($result, true, $meta);
    }

    public function create(Request $request)
    {
        try {
           $product = Product::query()->create($request->all());
            if ($product){
                return restful_success($product);
            }
            return restful_error();
        }catch (\Exception $e){
            return restful_exception($e);
        }
    }

    public function show($id)
    {
        Cache::put('user', 'this is user in cache', now()->addMilliseconds(50000));
        dd('show');
    }

    public function update($data)
    {
        dd('update');
    }

    public function delete()
    {
        dd('delete');
    }
}
