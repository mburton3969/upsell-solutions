<?php namespace App\Models;

use CodeIgniter\Model;

class NavModel extends Model
{
    protected $table = 'nav_links';

    protected $allowedFields = [
      'ID', 
      'nav_link_title',
      'nav_link_url',
      'nav_link_icon',
      'maintenance_mode',
      'maint_done_date',
      'maint_done_time',
      'permissions'
    ];

}