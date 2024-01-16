<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    //
    public function register(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'c_password'=> 'required|same:password',
            'role'=> 'required',
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        };

        $input = $request->all();
        $input ['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        
        return $this->sendResponse($success, 'Berhasil menambah user baru');
    }


    public function login(Request $request):JsonResponse
    {
        if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            
            return $this->sendResponse($success, 'Berhasil Login');
        }else{
            return $this->sendError('Tidak menemukan user', ['error'=> 'Tidak menemukan user']);
        }
    }

    public function index()
    {
        //
        $data = User::orderBy('name','asc')->get();
        return response()->json([
            'status'=> true,
            'message'=> 'Data ditemukan',
            'data'=> $data,
        ],200);
    }
}
