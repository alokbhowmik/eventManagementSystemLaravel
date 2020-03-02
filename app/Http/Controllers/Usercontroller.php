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
        $this->user->firstname = $request->input('firstname');
        $this->user->lastname = $request->input('lastname');
        $this->user->email = $request->input('email');
        $this->user->mob = $request->input('mob');
        $this->user->roleId = 3;
        $this->user->password = $request->input('password');
        $this->user->save();


        $arr = array(
            
            'status' => 4
        );
        return response()->json($arr);
    }

    function showUserData(Request $request)
    {
        return response()->json($request->input());
    }

    function userLogin(Request $request){

        // request for email and password
        $email = $request->input('email');
        $password = $request->input('pwd');

        $user = new UserModel();

        //select all data where email match 
        
        $userDetails = DB::table('user')->where('email', $email);
        
       
        // return response()->json($userDetails);
        if(strcmp($userDetails->value('password') , $password) == 0){

            $roleid = $userDetails->value('roleId');
            $arr = array(
                'user' => $userDetails->value('firstname'),
                'field' => 'login',
                'status' => $roleid,
            );
            return response()->json($arr);
        }
        else{

            return response()->json(array(
                'field' => 'login',
                'status' => 0,
            ));
        }
    }
}
