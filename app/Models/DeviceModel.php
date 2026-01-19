<?php

namespace App\Models;

use CodeIgniter\Model;

class DeviceModel extends Model
{
    protected $table            = 'trusted_devices';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id','device_hash', 'verified','last_seen'];

}
