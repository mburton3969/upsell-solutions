<?php namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
  public function index()
  {
    if(session()->get('in') == 'Yes'){
      return redirect()->to('/dashboard');
    }
    $data = [
      'login_mode' => 'active',
      'reg_mode' => '',
      'error' => ''
    ];
    helper(['form']);
    
    if($this->request->getMethod() == 'post'){
      
      //Registration Method...
      if($this->request->getVar('user_mode') == 'register'){
        //Setup Validation...
        $rules = [
          'fname' => 'required|min_length[4]|max_length[50]',
          'lname' => 'required|min_length[4]|max_length[50]',
          'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
          'password' => 'required|min_length[8]|max_length[255]',
          'password_confirm' => 'matches[password]',
          'gender' => 'required|min_length[4]|max_length[20]',
        ];

        if(! $this->validate($rules)) {
          $data['registration_validation'] = $this->validator;  
          $data['reg_mode'] = 'active';
          $data['login_mode'] = '';
        }else{
          //Store the user in database...
          $model = new UsersModel();
          
          $newData = [
            'fname' => $this->request->getVar('fname'),
            'lname' => $this->request->getVar('lname'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'gender' => $this->request->getVar('gender'),
          ];
          $model->save($newData);
          $data['registration_success'] = 'Registration Successful!';
        }
      }
      
      
      //Login Method...
      if($this->request->getVar('user_mode') == 'login'){
        //Setup Validation...
        $rules = [
          'email' => 'required|min_length[6]|max_length[50]|valid_email',
          'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
        ];
        
        $errors = [
          'password' => [
            'validateUser' => 'Invalid Email or Password!'
          ]
        ];

        if(! $this->validate($rules, $errors)) {
          $data['login_validation'] = $this->validator;  
        }else{
          $model = new UsersModel();
          
          $user = $model->where('email',$this->request->getVar('email'))
                        ->first();
          
          $this->setUserMethod($user);
          
          return redirect()->to('dashboard');
        }
      }
      
    }
    
    echo view('login', $data);
  }
  
  //--------------------------------------------------------------------
  
  private function setUserMethod($user)
  {
    $data = [
      'user_id' => $user['ID'],
      'fname' => $user['fname'],
      'lname' => $user['lname'],
      'user_name' => $user['fname'] . ' ' . $user['lname'],
      'user_email' => $user['email'],
      'avatar_url' => $user['avatar_url'],
      'admin' => $user['admin'],
      'in' => 'Yes'
    ];
    
    session()->set($data);
    return true;
  }

  //--------------------------------------------------------------------
  
  public function logout()
  {
    $data = [
      'login_mode' => 'active',
      'reg_mode' => '',
      'error' => ''
    ];
    $data['registration_success'] = 'Logout Successful!';
    session()->destroy();
    echo view('login',$data);
  }

  //--------------------------------------------------------------------


}