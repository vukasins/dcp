<?php
namespace Scaffolding\Service\Module;

use Scaffolding\Service\CreateInterface;

class CreateModuleClass implements CreateInterface
{
    private $name;

    private $configDir;

    private $module;

    public function __construct($name, $configDir, $module)
    {
        $this->name = $name;
        $this->configDir = $configDir;
        $this->module = $module;
    }

    public function create()
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Module/Module.txt');
        $template = str_replace("{{namespace}}", $this->name, $template);
        file_put_contents($this->module . '/Module.php', $template);
        return true;
    }
}