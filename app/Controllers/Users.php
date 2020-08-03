<?php namespace App\Controllers;

class Users extends BaseController
{
  public function index()
  {
    foreach($this->request->nav_links as $nl){
      $data['nav_links'][] = $nl;
    }
    $data['page_title'] = $this->request->page_title;
    
    return view('login', $data);
  }

  //--------------------------------------------------------------------

}