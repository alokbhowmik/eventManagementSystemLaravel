<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //
    protected $table = "users";
    public $timestamps = false;
    
    // protected $fillable =["firstname","lastname","email","mob","password","roleId"];
    function getData(){

    }
    
    
}
