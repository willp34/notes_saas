<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTeamInvitesTable extends Migration
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
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
			'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
            ],
			'status' => [
                'type'    => 'ENUM',
				'constraint' => "'pending','accepted','expired'",
				'default'  =>'pending'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]
			]);
			$this->forge->addKey('id', true);
		
		// Optional but recommended for FK performance
		$this->forge->addKey('team_id');

		// Foreign key
		$this->forge->addForeignKey(
			'team_id',
			'teams',
			'id',
			'CASCADE', // on delete
			'CASCADE'  // on update
		);
        $this->forge->createTable('teams_invites',true);
    }

    public function down()
    {
        //
		    $this->forge->dropTable('teams_invites', true);
    }
}
