<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\NavModel;
use App\Models\UsersModel;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request)
    {
      $navModel = new NavModel();
      $usersModel = new UsersModel();
      $path = $request->uri->getSegment(1);
      $navLinks = $navModel->where('nav_link_title !=','Dashboard')->orderBy('nav_link_title','asc')->find();
      foreach($navLinks as $nl){
          $request->nav_links[] = $nl;
        }
      session()->setFlashdata('nav_links',$request->nav_links);
      $navInfo = $navModel->where('nav_link_url',strtolower($path))->first();
      if(isset($navInfo)){
        $request->page_title = $navInfo['nav_link_title'];
        //Security Auth Check...
        $userInfo = $usersModel->where('ID',session()->get('user_id'))->first();
        if(isset($userInfo)){
          $userPermissions = json_decode($userInfo['permissions']);
          $navPermissions = json_decode($navInfo['permissions']);
          if(count($navPermissions->permissions) <= 0 || array_intersect($userPermissions->permissions,$navPermissions->permissions)){
            //Grant Access..
            
          }else{
            //Deny Access..
            return redirect()->to('/restricted_access');
          }
          //die();
        }else{
          if(session()->get('in') != 'Yes'){
           return redirect()->to('/logout'); 
          }
          return redirect()->to('/restricted_access');
        }
        
        //Maintenance Mode Check...
        if($navInfo['maintenance_mode'] == 'Yes'){
          session()->setFlashdata('pageTitle',$navInfo['nav_link_title']);
          session()->setFlashdata('maintenance_date',$navInfo['maint_done_date']);
          session()->setFlashdata('maintenance_time',$navInfo['maint_done_time']);
          return redirect()->to('/under_maintenance');
        }
      }
      
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}