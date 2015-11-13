<?php
namespace Scaffolding\Service\Module;

use Scaffolding\Service\CreateInterface;

class CreateModuleDir implements CreateInterface
{

    private $module;

    private $srcDir;

    private $configDir;

    private $moduleMainDir;

    private $name;

    public function __construct($name, $module, $srcDir, $configDir, $moduleMainDir)
    {
        $this->name = $name;
        $this->module = $module;
        $this->srcDir = $srcDir;
        $this->configDir = $configDir;
        $this->moduleMainDir = $moduleMainDir;
    }

    public function create()
    {
        mkdir($this->module, 0755);
        mkdir($this->srcDir, 0755);
        mkdir($this->configDir, 0755);
        mkdir($this->moduleMainDir, 0755);
        return true;
    }

}