<?php
namespace Scaffolding\Service\Module;

use Scaffolding\Service\CreateInterface;
use Scaffolding\Service\CreateIterator;
use ZFTool\Model\Config;
use ZFTool\Model\Skeleton;

class CreateModule implements CreateInterface
{
    private $name;

    private $module;

    private $srcDir;

    private $configDir;

    private $moduleMainDir;

    private $isMvc;

    public function __construct($name, $isMvc = false)
    {
        $this->name = ucfirst($name);
        $this->module = __DIR__ . "/../../../../../{$this->name}";
        $this->srcDir = $this->module . "/src";
        $this->configDir = $this->module . "/config";
        $this->moduleMainDir = $this->srcDir . "/{$this->name}";
        $this->isMvc = $isMvc;
    }

    public function create()
    {
        $createModuleDir = new CreateModuleDir(
            $this->name,
            $this->module,
            $this->srcDir,
            $this->configDir,
            $this->moduleMainDir
        );

        $iteratorModule = new CreateIterator();
        $config = $this->isMvc ? 'mvc.module.config.txt' : 'module.config.txt';
        $iteratorModule
            ->add($createModuleDir)
            ->add(new CreateModuleClass($this->name, $this->configDir, $this->module))
            ->add(new CreateModuleConfig($this->configDir, $config))
            ->add(new CreateViewDir($this->module, $this->name));

        $iteratorModule->execute();
        $this->registerModule($this->name);
        return true;

    }

    private function strContains($haystack, $needle)
    {
        if (strpos($haystack,$needle) !== false) {
            return true;
        }
        return false;
    }

    private function registerModule($moduleName)
    {
        $moduleName = ucfirst($moduleName);
        $data = "";
        $appConfig = @fopen(__DIR__ . "/../../../../../../config/application.config.php", 'r');
        if ($appConfig) {
            while(($line = fgets($appConfig, 4096)) !== false) {
                if($this->strContains($line, '\'modules\'') || $this->strContains($line, '"modules"')) {
                    $data .= $line;
                    $spaceCount = substr_count($line, ' ');
                    $spaces = ' ';
                    for($i=0; $i<=$spaceCount;$i++) {
                        $spaces .= ' ';
                    }
                    $data .= $spaces . "'{$moduleName}',\n";
                } else {
                    $data .= $line;
                }
            }
            if (!feof($appConfig)) {

            }
            fclose($appConfig);
        }

        $file = @fopen(__DIR__ . "/../../../../../../config/application.config.php", "w");
        fwrite($file, $data);
        fclose($file);
    }

}