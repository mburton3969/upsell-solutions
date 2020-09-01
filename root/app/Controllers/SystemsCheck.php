<?php namespace App\Controllers;

class SystemsCheck extends BaseController
{
  public function index()
  {
    phpinfo();
  }

  //--------------------------------------------------------------------

  public function hash_pass()
  {
    $hashedPassword = password_hash($this->request->getVar('p'), PASSWORD_DEFAULT);
    echo $hashedPassword;
  }

  //--------------------------------------------------------------------

}