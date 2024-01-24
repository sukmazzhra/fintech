<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return response()->json([
            'message'=>'Berhasil mengambil data user',
            'status'=>200,
            'data'=>$users
        ]);
    }
    public function store(Request $request){
        if($request->confirm_password == $request->password){
            $user = User::create([
                'name'=> $request->name,
                'username'=> $request->username,
                'password'=> Hash::make($request->password),
                'role'=> $request->role
            ]);
            if($user){
                return redirect()->back()->with('status','Berhasil menambah user');
            }
        }
        return redirect()->back()->with('status','Gagal menambah user');
    }

    public function update(Request $request, string $user){
        $checkUsername = User::withTrashed()->where('username',$request->username)->first();

        if($checkUsername && $request->username == User::find($user)->username){
            return redirect()->back()->with('status','Username sudah digunakan');
        }
        else{
            if($request->confirm_password == $request->password){
                $data=[
                    'name'=> $request->name,
                    'username'=> $request->username,
                    'role'=> $request->role
                ];

                if($request->password != ""){
                    $data['password'] = Hash::make($request->password);
                }
                $user=User::find($user)->update($data);
            }
        }
    }
}
