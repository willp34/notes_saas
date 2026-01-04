<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginVerifyModel extends Model
{
    protected $table            = 'login_verifications';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id','token','expires_at','ip', 'user_agent' ];
	protected $useTimestamps = true;
   

   
}
