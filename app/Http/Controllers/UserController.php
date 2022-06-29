<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // register function
    public function register(Request $request){
       $request->validate([
         'name'=>'required|min:3',
         'email'=>'required|email|unique:users,email',
         'password'=>'required|min:6',
         'password_confirmation'=>'required_with:password|same:password|min:6',
       ]);
       User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
       ]);
       return response()->json(['message'=>'Compte Created SuccessFully']);
    }

    // login function
    public function login(Request $request){
      $request->validate([
        'email'=>'required|email',
         'password'=>'required|min:5',
      ]);
      $user = User::where('email',$request->email)->first();
      if(isset($user->id)){
        if(Hash::check($request->password,$user->password)){
            $token= $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message'=>'Connected Successfully',
                'token' => $token,
                'id' => $user->id,
                'admin' => $user->admin,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $user->image,
            ]);
        }else{
            return response()->json(['message'=>'invalid User'], 422);
        }
       }else{
        return response()->json(['message'=>'invalid User'], 422);
       }
    }
    public function profile(){
        return response()->json(['user'=>auth('sanctum')->user()]);
    }

    public function editProfile(Request $request,$id){
        $upload_path = public_path('images/profile');
        $user = User::where('id',$id)->first();
        $data =json_decode($request->data,true);
        $rules = [
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'password'=>'min:6',
            'password_confirmation'=>'required_with:password|same:password|min:6',
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{

            if($request->hasFile('file') && !empty($data['password']) ){
                $user->password =Hash::make($data['password']);
                $image_path = $user->image;
                if(File::exists($image_path)){
                    unlink($image_path);
                }
                $user->image = '/images/profile/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);


            }elseif($request->hasFile('file') && empty($data['password'])){
                $image_path = $user->image;
                if(File::exists($image_path)){
                    unlink($image_path);
                }
                $user->image = '/images/profile/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);
            }

            $user->update([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>$user->password ,
                'image'=>$user->image
            ]);
            return response()->json(['message'=>'Profile Updated SuccessFully']);

        }
    }

    // logout function
    public function logout(){
        // delete token
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'message'=>'Logout successfully',
        ]);
    }


}
