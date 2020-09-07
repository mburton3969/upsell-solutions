<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNavLinksTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'ID'          => [
                    'type'           => 'INT',
                    'auto_increment' => TRUE
            ],
            'nav_link_title'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '50',
            ],
            'nav_link_url'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '50',
            ],
            'nav_link_icon'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '50',
            ],
            'maintenance_mode'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '30',
            ],
            'maint_done_date'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '30',
            ],
            'maint_done_time'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '30',
            ],
            'permissions'       => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '500',
            ],
    ]);
    $this->forge->addPrimaryKey('ID');
    $this->forge->createTable('nav_links',TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('nav_links');
	}
}