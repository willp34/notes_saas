<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TeamModel;

class CleanupTeams extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'teams:cleanup';
    protected $description = 'Delete all teams with empty or null names.';

    public function run(array $params)
    {
        $model = new TeamModel();

        // Count records BEFORE deletion
        $count = $model->where('name', '')
                       ->orWhere('name', null)
                       ->orWhere('TRIM(name) = \'\'', null, false)
                       ->countAllResults();

        if ($count == 0) {
            CLI::write('No empty team names found.', 'yellow');
            return;
        }

        // Delete them
        $model->deleteEmptyNames();

        CLI::write("Deleted {$count} teams with empty names.", 'green');
    }
}