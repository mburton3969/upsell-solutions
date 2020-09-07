<?php namespace App\Controllers;

class ApiController extends BaseController
{
  public function index()
  {
    foreach($this->request->nav_links as $nl){
      $data['nav_links'][] = $nl;
    }
    $data['page_title'] = $this->request->page_title;
    
    return view('dashboard', $data);
  }

  //--------------------------------------------------------------------
  
  public function header_data()
  {
    $db = db_connect();
    //Get Activity...
    $ulq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . session('user_id') . "' AND `log_type` = 'UPC Scan' AND `date` = CURRENT_DATE AND `user_id` = '" . session('user_id') . "'";
    $ulg = $db->query($ulq)->GetResult();
    //$slq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . session('user_id') . "' AND `log_type` = 'Listing_Store' AND `date` = CURRENT_DATE AND `listed` = 'Yes' AND `user_id` = '" . session('user_id') . "'";
    //$slg = $db->query($slq)->GetResult();
    //$elq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . session('user_id') . "' AND `log_type` = 'Listing_Ebay' AND `date` = CURRENT_DATE AND `listed` = 'Yes' AND `user_id` = '" . session('user_id') . "'";
    //$elg = $db->query($elq)->GetResult();
    //$ilq = "SELECT * FROM `ebay_imports` WHERE `user_id` = '" . session('user_id') . "' AND `status` = 'Imported' AND `date` = CURRENT_DATE AND `user_id` = '" . session('user_id') . "'";
    //$ilg = $db->query($ilq)->GetResult();
    //Counts...
    $upc_count = count($ulg);
    //$store_count = count($slg);
    //$ebay_count = count($elg);
    //$import_count = count($ilg);
    //$total_store_count = $store_count - $import_count;
    //$total_ebay_count = $ebay_count - $import_count;
    
    $x['upc_count'] = $upc_count;
    return $this->response->setJSON($x);
  }

  //--------------------------------------------------------------------

}