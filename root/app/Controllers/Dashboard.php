<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
    $data['pageTitle'] = 'Dashboard';
    foreach($this->request->nav_links as $nl){
      $data['nav_links'][] = $nl;
    }
		return view('dashboard',$data);
	}

	//--------------------------------------------------------------------

}
