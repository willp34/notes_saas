<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrustedDevicesTable extends Migration
{
    public function up()
    {
        //
		$this->forge->addField([
		 'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'device_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
			'last_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
				'null' =>true,
            ],
            'last_seen' => [
                'type' => 'DATETIME',
                'null' => true,
				
            ],
			'verified' => [
                'type'    => 'TINYINT',
				 'constraint'     => 1,
                'default'    => 0,
            ]
	]);
			$this->forge->addKey('id', true);
		
		// Optional but recommended for FK performance
		$this->forge->addKey('user_id');

		// Foreign key
		$this->forge->addForeignKey(
			'user_id',
			'users',
			'id',
			'CASCADE', // on delete
			'CASCADE'  // on update
		);
        $this->forge->createTable('trusted_devices',true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('trusted_devices',true);
    }
}
