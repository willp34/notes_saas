<?php 

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
	protected $table = "notes";
	protected $primaryKey= 'id';
	protected $allowedFields = ['content','user_id','team_id'];
	protected $returnType = 'array';
	protected $useTimestamps = true;
	
	public function userCanAccess($noteId, $userId)
    {
        $note = $this->find($noteId);
        if (!$note) return false;

        if ($note['user_id'] === $userId && !$note['team_id']) {
            return true;
        }

        if ($note['team_id']) {
            return (new TeamUserModel())->belongsToTeam($note['team_id'], $userId);
        }

        return false;
    }
	}