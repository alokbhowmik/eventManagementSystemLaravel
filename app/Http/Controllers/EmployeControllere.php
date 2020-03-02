<?php

namespace App\Http\Controllers;

use App\EmployeeModel;
use Illuminate\Http\Request;

class EmployeControllere extends Controller
{
    //
    
    function index(){
        
    }
    function getData(){
        $employee = new EmployeeModel();
        return $employee::all()->toArray();
        return $employee->getData();
    }
}
