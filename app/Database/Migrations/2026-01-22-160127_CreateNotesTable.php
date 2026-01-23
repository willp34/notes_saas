<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;


class CreateNotesTable extends Migration
{
    public function up()
    {
        //
		  //
		$this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'content' => [
                'type'       => 'TEXT',
                
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'   => true,
            ],
            'team_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
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
        $this->forge->createTable('notes',true);
    }

    public function down()
    {
        //
    }
}
