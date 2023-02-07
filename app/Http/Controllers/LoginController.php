<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    
    public function userDashboard()
    {
        $users = User::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function adminDashboard()
    {
        $users = Admin::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

       else{ 
            $user = array(
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
               
            );
            return User::create($user);
        }
        }
        public function signin(Request $request){
            $fields = $request->validate([

                'email'=>'required|string|email',
                'password'=>'required|string'   
               ]);
       
               //Check email
       
               $user= User::where('email', $fields['email'])->first();
       
               //Check Password
               if(!$user || !Hash::check($fields['password'], $user->password) ){
                   return response([
                       'message'=>'Invalid Credentials'
                   ], 401);
               }
       
               $token = $user->createToken('Employee' , ['is_employee'])->accessToken;
       
               $response= [
                   'user' => $user,
                   'token'=> $token,
                   'messgae' => "Login success"
               ];
       
               return response($response, 201);
           }
       
        
    
    

    public function adminLogin(Request $request)
    {
      
            $admin = array(
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
               
            );
            return Admin::create($admin);
        
    }


    public function adminsignin (Request $request){

        $fields = $request->validate([

            'email'=>'required|string|email',
            'password'=>'required|string'   
           ]);
   
           //Check email
   
           $user= Admin::where('email', $fields['email'])->first();
   
           //Check Password
           if(!$user || !Hash::check($fields['password'], $user->password) ){
               return response([
                   'message'=>'Invalid Credentials'
               ], 401);
           }
   
           $token = $user->createToken('Admin' , ['is_admin'])->accessToken;
   
           $response= [
               'admin' => $user,
               'token'=> $token,
               'messgae' => "Login success"
           ];
   
           return response($response, 201);
       }
   
 }
