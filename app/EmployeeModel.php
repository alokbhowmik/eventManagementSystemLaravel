<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    //
    protected $table = "users";

    function getdata(){
        echo "hello guyes... ";
    }
   
}
