<?php

declare(strict_types=1);

namespace App\Commands ;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\GeneratorTrait;

use CodeIgniter\CLI\CLI;




class FactoryGenerator extends BaseCommand
{
    use GeneratorTrait;

    protected $group       = 'Generators';
    protected $name        = 'make:factory';
    protected $description = 'Generates a new factory file.';
    protected $usage       = 'make:factory <name>';
    protected $arguments   = [
        'name' => 'The factory class name.',
    ];
    protected $options     = [
        '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
        '--suffix'    => 'Append the component title to the class name (e.g. User => UserFactory).',
        '--force'     => 'Force overwrite existing file.',
    ];

    


			// ❌ DO NOT re-declare $component, $directory, $templatePath, $template
    // Instead, set them in the `run()` method below.
	//protected $templatePath; // just declare it here
     
 public function run(array $params)
    {
		
        // Assign trait properties here instead of declaring above:
        $this->component     = 'Factory';
        $this->directory     = 'Database\Factories';
        $this->template      = 'factory.tpl.php';
		//$this->templatePath  = APPPATH . 'Commands/Templates'; // ✅ This line is critical
		$this->templatePath  = APPPATH . 'Commands\Templates'; // Make sure trailing slash and path correct
        
		$this->classNameLang = 'CLI.generator.className.factory';
		
		
		
        CLI::write('About to call generateClass()  '.$this->templatePath, 'yellow');
		$this->generateClass($params);
		CLI::write('Finished generateClass()', 'yellow');
    }
	protected function getTemplate(): string
	{
		$templatePath = rtrim($this->templatePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->template;

		if (!is_file($templatePath)) {
			CLI::error("Template not found at: $templatePath");
			exit(1);
		}

		CLI::write("Using template: $templatePath", 'yellow');
		return $templatePath;
	}
/*	 public function run(array $params)
    {
        // Validate class name argument
        if (!isset($params['name'])) {
            CLI::error('You must provide a class name.');
            return;
        }

        $className = $params['name'];

        $namespace = $params['namespace'] ?? 'App\Database\Factories';

        // Folder path for factories
        $directory = APPPATH . 'Database/Factories/';

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // File path for new factory class
        $filePath = $directory . $className . '.php';

        if (file_exists($filePath) && empty($params['force'])) {
            CLI::error("File {$filePath} already exists! Use --force to overwrite.");
            return;
        }

        // Determine model class from factory name by removing 'Factory' suffix
        $entity = preg_replace('/Factory$/', '', $className);

        // Read template file from your custom Views folder
        $templatePath = APPPATH . 'Commands/Views/factory.tpl.php';

        if (!file_exists($templatePath)) {
            CLI::error("Template file not found: {$templatePath}");
            return;
        }

        $template = file_get_contents($templatePath);

        // Replace placeholders
        $replacements = [
            '{namespace}' => $namespace,
            '{class}'     => $className,
            '{entity}'    => $entity,
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $template);

        // Save the generated factory file
        file_put_contents($filePath, $content);

        CLI::write("Factory created: {$filePath}", 'green');
    }
	
	*/
}