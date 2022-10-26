<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->paginate(5);
        $result = [];
        foreach ($users as $user){
            $result[] = $user;
        }
        $meta = get_meta($users);
        return restful_success($result, true, $meta);
    }

    public function create(Request $request)
    {
        try {
            $user = User::query()->create($request->all());
            if ($user){
                return restful_success($user);
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
