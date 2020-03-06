<?php

namespace App\Http\Controllers;

use App\EmployeeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeControllere extends Controller
{
    //
    private $employee ;
    function __construct()
    {
        $this->employee = new EmployeeModel();
    }
   
    function index(){
        
    }
    function getData(){
       
        
        return $this->employee::all()->toArray();
    }
    //################# view employee ########### 

    function viewEmployee(){
        return $this->employee::all()->where('roleId',2)->where('status',0)->toArray();
    }
    // $$$$$$$$$$$$ delete Employee $$$$$$$$$$$$
    function deleteEmployee($id){
       
       $user = DB::table('users')->select('firstname')->where('user_id',$id)->get();
        
        DB::update('update users set status = true where user_id = ?', [$id]);
        return response()->json(array(
            'id'=>0,
            'message'=>$user[0]->firstname.' deleted successfully',
            
        ));
        
    }
}
