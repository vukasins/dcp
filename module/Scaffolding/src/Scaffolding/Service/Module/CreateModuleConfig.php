<?php
namespace Scaffolding\Service\Module;

use Scaffolding\Service\CreateInterface;

class CreateModuleConfig implements CreateInterface
{

    private $configDir;
    private $moduleConfigLoc;

    public function __construct($configDir, $moduleConfigLoc = 'module.config.txt')
    {
        $this->configDir = $configDir;
        $this->moduleConfigLoc = $moduleConfigLoc;
    }

    public function create()
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Module/' . $this->moduleConfigLoc);
        file_put_contents($this->configDir . '/module.config.php', $template);
        return true;
    }
}