<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
      'date',
      'time',
      'fname', 
      'lname', 
      'username', 
      'password',
      'permissions',
      'inactive'
    ];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
  
    protected function beforeInsert(array $data){
      $data = $this->passwordHash($data);
      $x = (object) null;
      $x->permissions = array();
      $data['data']['permissions'] = json_encode($x);
      
      return $data;
    }
  
    
    protected function beforeUpdate(array $data){
      $data = $this->passwordHash($data);
      
      
      return $data;
    }
  
  
    protected function passwordHash(array $data){
      if(isset($data['data']['password']))
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
      
      return $data;
    }
  
}