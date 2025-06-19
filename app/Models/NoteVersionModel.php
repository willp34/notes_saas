<?php 

namespace App/Models;

use Codigniter/Model;

class NoteVersionmodel extends Model
{
	protected $table = "note_versions";
	protected $primaryKey= 'id';
	protected $allowedFields = ['note_id','content','edited_by', 'edited_at'];
	protected $returnType = 'array';
	protected $useTimestamps = false;
	
	}