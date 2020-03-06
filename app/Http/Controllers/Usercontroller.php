<?php

namespace App\Http\Controllers;

use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Usercontroller extends Controller
{
    private $user;
    

    function  __construct()
    {
        $this->user = new UserModel();
        $this->request = Request::createFromGlobals();
        $this->response = new Response();
    }
    // $$$$$$$$$$$$$$ SAVE USER DATA $$$$$$$$$$$$$
    function saveUserData(Request $request)
    {
        $email = $request->input('email');
        // $email = 'admin@admin.com';
        $validUser = DB::table('users')->where('email',$email)->value('email');
        if(!empty($validUser))
        {
            return response()->json(array(
                'id' => 0,
                'email' => $validUser,
                'status' => false,
                'message' => 'please select an another email'
            ));
        }
        else{
            $data = array(
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $email,
                'mob' => $request->input('mob'),
                'roleId' =>(int)$request->input('roleid'),
                'password' => md5($request->input('password')),
                'status'=> 0
            );
            DB::table('users')->insert($data);
    
            $arr = array(
                'firstname' => $request->input('firstname'),
                'status' => true,
                "message" => "successfull Login"
    
            );
            return response()->json($arr);
        }
    }
    // ########## SHOW USER DATA ################ 
    function showUserData(Request $request)
    {
        
        $token = $request->header('Token');
        $user_id = DB::table('tokens')->where('token',$token)->value('user_id');
        $user_details = DB::table('users')->where('user_id',$user_id);
        return response()->json(array(
           
            'firstname' => $user_details->value('firstname'),
            'lastname' => $user_details->value('lastname'),
            'email' => $user_details->value('email'),
            
        ));
        
        
    }

    //########### SAVE TOKEN FUNCTION ################ 
    function saveToken($userId, $token)
    {
        $token_data = array(
            'user_id' => $userId,
            'token' => $token
        );
        DB::table('tokens')->insert($token_data);
    }

    //################## USER LOGIN FUNCTION ######################
    
    function userLogin(Request $request)
    {

        // request for email and password
        $email = $request->input('email');
        $password =md5($request->input('pwd'));
        $token = $this->tokenGenerate();
        
        if($email == null){
            return response()->json(array(
                'role_id' => 0,
                'field' => 'login',
                "message" => "email can't be null"
            ));
        }
        $user = new UserModel();

        //select all data where email match 

        $userDetails = DB::table('users')->where('email', $email);


        // return response()->json($userDetails);
        if (strcmp($userDetails->value('password'), $password) == 0) {

            $user_id = $userDetails->value('user_id');
            $roleid = $userDetails->value('roleId');
            $this->saveToken($user_id, $token);
            $arr = array(
                'role_id' => $roleid,
                'field' => 'login',
                'token' => $token,
                'user' => $userDetails->value('firstname'),
                "message" => "successfull Login"
            );
            return response()->json($arr);
        } else {

            return response()->json(array(
                'role_id' => 0,
                'field' => 'login',
                "message" => "email or password might be wrong"
            ));
        }
    }
    //################ TOKEN GENERATE ################ 
    function tokenGenerate($length = 15){
        $ranstr = "abcdefghijklmnopqrstABCDEFGHIJKLMNOP0123456789";
        $token = "";
        for ($i=0; $i < $length; $i++) { 
            # code...
            $token .= $ranstr[rand(0,strlen($ranstr)-1)];
        }
        return $token;
    }
    //################ VIEW USERES #################### 
    function viewUsers(){
        return DB::table('users')->select('user_id','firstname','lastname','email','mob')->where('roleId',3)->where('status',0)->get();
        
    }
    //################ DELETE USERES #################### 
    public function deleteUser(){
        
    }
}
