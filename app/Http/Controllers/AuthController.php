<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::query()->create($data);
            if ($user){
                return restful_success($user, ResponseAlias::HTTP_CREATED);
            }
            return restful_error('dang ki that bai');
        }catch (\Exception $e){
            return restful_error($e, ResponseAlias::HTTP_CONFLICT);
        }
    }

    public function login(LoginRequest $request)
    {
//        try {
            $credentials  = $request->validated();
//            dd(config('sanctum.expiration'));
            if (!Auth::attempt($credentials)){
              abort(404, 'wrong email or password');
            }
            $user = $request->user();

        $tokenResult = $user->createToken('basic')->plainTextToken;
//            $token->save();
            $user['token'] = $tokenResult;
            return restful_success($user, ResponseAlias::HTTP_OK);
//        } catch (\Exception $e) {
//            return restful_exception($e);
//        }
    }

    public function profile($id)
    {
        Cache::put('user', 'this is user in cache', now()->addMilliseconds(50000));
        dd('show');
    }

    public function logout(){
        try {
            \auth()->user()->currentAccessToken()->delete();
            return restful_success('logout success');
        }catch (\Exception $e){
            return restful_exception($e);
        }
    }

}
