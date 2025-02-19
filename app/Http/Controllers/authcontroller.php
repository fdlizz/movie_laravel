<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;


class authcontroller extends Controller
{
    function register(request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'address'=>'required',
            'birthday' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);
    
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => $validator->errors()]);
            }
            $data = [
                'name' =>$request-> get('name'),
                'email' =>$request-> get('email'),
                'password' => Hash::make($request-get('password')),
                'address' =>$request-> get('address'),
                'birthday' =>$request-> get('birthday')
                ];
                try{
                    $insert = User::create($data);
                    return Respone()-json(["status"+true,"message"=>"data berhasil ditambahkan"]);
                } catch(Exception $e) {
                    return  Respone()->json(["status"=>false,"message"=>$e]);
                }
    }

    function getUser() {
        try{
            $user = User::get();
            return response()->json([
                'status'=>true,
                'message'=>'berhasil load data user',
                'data'=>$user,
            ]);
        } catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'gagal load data user. '. $e,
            ]);
        }
    }

    function getDetailUser($id) {
        try{
            $user = User::where('id',$id)->first();
            return response()->json([
                'status'=>true,
                'message'=>'berhasil load data detail user',
                'data'=>$user,
            ]);
        } catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'gagal load data detail user. '. $e,
            ]);
        }
    }

    function update_user($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>['required', Rule::unique('users')->ignore($id)],
            "address"=>'required',
            "birthday"=>'required',
            'role'=>'required',
            'password'=>'required',
        ]);


        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }
        $data = [
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'password'=>Hash::make($request->get('password')),
            'role'=>$request->get('role'),
            "address"=>$request->get("address"),
            "birthday"=>$request->get("birthday"),
        ];
        try {
            $update = User::where('id',$id)->update($data);
            return Response()->json([
                "status"=>true,
                'message'=>'Data berhasil diupdate'
            ]);


        } catch (Exception $e) {
            return Response()->json([
                "status"=>false,
                'message'=>$e
            ]);
        }
    }

    function hapus_user($id) {
        try{
            User::where('id',$id)->delete();
            return Response()->json([
                "status"=>true,
                'message'=>'Data berhasil dihapus'
            ]);
        } catch(Exception $e){
            return Response()->json([
                "status"=>false,
                'message'=>'gagal hapus user. '.$e,
            ]);
        }
    }



}
