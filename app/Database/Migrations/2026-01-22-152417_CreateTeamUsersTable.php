<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\RawSql;

use CodeIgniter\Database\Migration;

class CreateTeamUsersTable extends Migration
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
			'team_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
			'role' => [
                'type'    => 'ENUM',
				'constraint' => "'admin','member'",
				'default' => 'member',
              ]
			  ]);
			$this->forge->addKey('id', true);
		
		$this->forge->addKey('team_id');

		// Foreign key
		$this->forge->addForeignKey(
			'team_id',
			'teams',
			'id',
			'CASCADE', // on delete
			'CASCADE'  // on update
		);
		
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
        $this->forge->createTable('team_users',true);
    }

    public function down()
    {
        //
		$this->forge->dropTable('team_users',true);
    }
}
