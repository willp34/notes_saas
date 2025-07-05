<?php

namespace App\Controllers\Api;


use CodeIgniter\RESTful\ResourceController;
use App\Models\NoteModel;
use App\Models\NoteVersionModel;
use App\Models\UserModel; 

class Note extends ResourceController
{
    
	Protected $noteModel;
	protected $versionModel;
	protected $user;

	public function  __construct()
	{
		$this->user = new UserModel();
		$this->noteModel =new NoteModel();
		$this->versionModel = new NoteVersionModel();
	}
	
	
	/**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
	 
	 
    public function index()
    {
        //
			$data = $this->request->getJSON(true);
			
			if(empty($data['teamid'])){
				return $this->failForbidden('Access denied Team Id not selected.');
			}
			$teamID = $data['teamid'];
			$this->user = $this->request->user;
			
			
			if($teamID){
				 if (!$this->user->belongsToTeam($teamId)) {
                return $this->failForbidden('Access denied.');
				}
			     $notes = $this->noteModel->where('team_id', $teamId)->findAll();
			} else {
				$notes = $this->noteModel->where('user_id', $this->user['id'])->where('team_id', null)->findAll();
			}
		
		return $this->respond($note);
		
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }


    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
		$data = $this->request->getJSON(true);
        $teamId = $data['team_id'] ?? null;

        if ($teamId && !$this->user->belongsToTeam($teamId)) {
            return $this->failForbidden('Access denied.');
        }

        $noteData = [
            'content' => $data['content'],
            'team_id' => $teamId,
            'user_id' => $this->user->id
        ];

        $noteId = $this->noteModel->insert($noteData);

        $this->versionModel->insert([
            'note_id' => $noteId,
            'content' => $data['content'],
            'edited_by' => $this->user->id,
            'edited_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respondCreated(['id' => $noteId]);
		
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
		$note = $this->noteModel->find($id);
        if (!$note) return $this->failNotFound();

        if ($note['team_id'] && !$this->user->belongsToTeam($note['team_id'])) {
            return $this->failForbidden();
        }

        if (!$note['team_id'] && $note['user_id'] != $this->user->id) {
            return $this->failForbidden();
        }

        $data = $this->request->getJSON(true);
        $this->noteModel->update($id, ['content' => $data['content']]);

        $this->versionModel->insert([
            'note_id' => $id,
            'content' => $data['content'],
            'edited_by' => $this->user->id,
            'edited_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respond(['message' => 'Note updated.']);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
