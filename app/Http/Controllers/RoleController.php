<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()->paginate(5);
        $result = [];
        foreach ($roles as $role){
            $result[] = $role;
        }
        $meta = get_meta($roles);
        return restful_success($result, true, $meta);
    }

    public function create(Request $request)
    {
        try {
            $role = Role::query()->create($request->all());
            if ($role){
                return restful_success($role);
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
