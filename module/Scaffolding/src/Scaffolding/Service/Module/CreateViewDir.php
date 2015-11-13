<?php
namespace Scaffolding\Service\Module;

use Scaffolding\Service\CreateInterface;

class CreateViewDir implements CreateInterface
{

    private $viewDir;
    private $errorDir;
    private $layoutDir;
    private $moduleDir;

    public function __construct($moduleDir, $moduleName)
    {
        $moduleName = strtolower($moduleName);
        $this->viewDir = "{$moduleDir}/view";
        $this->errorDir = "{$this->viewDir}/error";
        $this->layoutDir = "{$this->viewDir}/layout";
        $this->moduleDir = "{$this->viewDir}/{$moduleName}";
    }

    public function create()
    {
        mkdir($this->viewDir, 0755);
        mkdir($this->errorDir, 0755);
        $this->createFile("{$this->errorDir}/404.phtml");
        $this->createFile("{$this->errorDir}/index.phtml");
        mkdir($this->layoutDir, 0755);
        $this->createFile("{$this->layoutDir}/layout.phtml");
        mkdir($this->moduleDir, 0755);
    }

    public function createFile($loc)
    {
        $file = fopen($loc,'w');
        fclose($file);
    }

}