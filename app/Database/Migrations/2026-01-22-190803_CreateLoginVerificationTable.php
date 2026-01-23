<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateLoginVerificationTable extends Migration
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
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
				'null' => null
            ],
			
            'expires_at' => [
                'type'           => 'DATETIME',
				'null' => true,
            ],
            'ip' => [
                'type'       => 'VARCHAR',
				'constraint' => 45,
                'null' => true,
            ], 
			'user_agent' => [
                'type'       => 'text',
                'null' => true,
            ],
			
			
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' => new  RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' =>new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
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
        $this->forge->createTable('login_verifications',true);
    }

    public function down()
    {
        //
    }
}
