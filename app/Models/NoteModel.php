<?php 

namespace App/Models;

use Codigniter/Model;

class NoteModel extends Model
{
	protected $table = "notes";
	protected $primaryKey= 'id';
	protected $allowedFields = ['content','user_id','team_id'];
	protected $returnType = 'array';
	protected $useTimestamps = true;
	
	}