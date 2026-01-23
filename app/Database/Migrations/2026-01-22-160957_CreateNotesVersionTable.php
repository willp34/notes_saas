<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNotesVersionTable extends Migration
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
            'content' => [
                'type'       => 'TEXT',
                
            ],
            'note_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'edited_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'edited_at' => [
                'type' => 'DATETIME',
                'null' => true,
				'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]
          
			
           
        ]);

       $this->forge->addKey('id', true);
		
		$this->forge->addKey('note_id');

		// Foreign key
		$this->forge->addForeignKey(
			'note_id',
			'notes',
			'id',
			'CASCADE', // on delete
			'CASCADE'  // on update
		);
		
		// Optional but recommended for FK performance
		$this->forge->addKey('edited_by');

		// Foreign key
		$this->forge->addForeignKey(
			'edited_by',
			'users',
			'id',
			'CASCADE', // on delete
			'CASCADE'  // on update
		);
        $this->forge->createTable('notes_versions',true);
    }

    public function down()
    {
        //
		$this->forge->dropTable('notes_versions',true);
    }
}
