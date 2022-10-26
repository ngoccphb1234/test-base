<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $user = User::query()->create($data);
            if ($user){
                return restful_success($user);
            }
            return restful_error('dang ki that bai');
        }catch (\Exception $e){
            return restful_exception($e);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
//            dd(Hash::check('123456','$2a$04$2ZYUoch7lD5c/nmaqF8i6evbzi.6Brn5G5RRQh1GIuYTQaYOUIxfy'));
            $credentials  = $request->validated();
            if (!Auth::attempt($credentials)){
                return restful_error('dang nhap that bai');
            }
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;
//            $token->save();
            $user['token'] = $token;
            return restful_success($user);
        } catch (\Exception $e) {
            return restful_exception($e);
        }
    }

    public function profile($id)
    {
        Cache::put('user', 'this is user in cache', now()->addMilliseconds(50000));
        dd('show');
    }

}
