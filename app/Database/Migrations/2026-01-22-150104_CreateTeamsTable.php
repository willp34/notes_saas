<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeamsTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_by' => [
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => true,
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('created_by');

		$this->forge->addForeignKey(
			'created_by',
			'users',
			'id',
			'CASCADE',
			'CASCADE'
		);
        $this->forge->createTable('teams',true);
    }

    public function down()
    {
        //
		 $this->forge->dropTable('teams', true);
    }
}
