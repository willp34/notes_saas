<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUsersTable extends Migration
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
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
				'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
				'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
			
            'reset_token' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
				'null' => true,
            ],
            'reset_expires_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'failed_attempts' => [
                'type'       => 'INT',
                'constraint' => 11,
				'default'    => 0,
            ],
            'lock_until' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'two_factor_enabled' => [
                  'type' => 'TINYINT',
					'constraint' => 1,
					'unsigned' => true,
					'default' => 0,
					'null' => false,
            ],
			
            'two_factor_secret' => [
                'type' => 'VARCHAR',
                'constraint'     => 255,
				'null' => true,
            ],
            'two_factor_confirmed' => [
                'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
				'null' => false,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);
		
    
    }

    public function down()
    {
        //    
		$this->forge->dropTable('users', true);
	}	
}
