<?php
namespace App\Validation;
use App\Models\UsersModel;

class UserRules
{
  
  public function validateUser(string $str, string $fields, array $data){
    $model = new UsersModel();
    //Check if User Email exists in database
    $user = $model->where('username', $data['username'])
                  ->first();
    //If not exists return false...
    if(!$user)
      return false;
    
    //if exists, check to see if password is correct...
    return password_verify($data['password'], $user['password']);
  }
}