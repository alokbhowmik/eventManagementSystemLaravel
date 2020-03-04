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
    //
    function saveUserData(Request $request)
    {
        // return response()->json($request->input('password'));
        $data = array(
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'mob' => $request->input('mob'),
            'roleId' => 3,
            'password' => md5($request->input('password'))
        );
        DB::table('users')->insert($data);

        $arr = array(
            'firstname' => $request->input('firstname'),
            'status' => true,
            "message" => "successfull Login"

        );
        return response()->json($arr);
    }

    function showUserData(Request $request)
    {
        // echo "hi sir ...";
        // DB::table('users')->select('*')
        return response()->json($request->input());
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
        $token = $request->input('token');
        // return response()->json($request->input());
        if($email == null){
            return response()->json(array(
                'role_id' => 0,
                'field' => 'login',
                'token' => $token,
                "message" => "email can't be null"
            ));
        }
        $user = new UserModel();

        //select all data where email match 

        $userDetails = DB::table('users')->where('email', $email);


        // return response()->json($userDetails);
        if (strcmp($userDetails->value('password'), $password) == 0) {

            $user_id = $userDetails->value('user_id');
            $this->saveToken($user_id, $token);
            $roleid = $userDetails->value('roleId');
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
                'token' => $token,
                "message" => "email or password might be wrong"
            ));
        }
    }
}
