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
    $pwd = $this->request->getVar('p');
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
    echo $hashedPassword . '<br>';
    $dbpwd = $hashedPassword;
    echo $dbpwd . '<br>';
    if(password_verify(trim($pwd), $dbpwd))
    {
        echo 'Match<br>';
    }
    else
    {
        echo 'Match failed<br> ';
    }
  }

  //--------------------------------------------------------------------

}