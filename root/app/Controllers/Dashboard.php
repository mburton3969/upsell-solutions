<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
    $data['pageTitle'] = 'Dashboard';
		return view('dashboard',$data);
	}

	//--------------------------------------------------------------------

}
