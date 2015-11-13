<?php

namespace Scaffolding\Service\Controller;

class CreateControllerService
{
    /**
     * We are doing 2 part:
     * 1. check enviroment
     * 2. create/cgange files on file system
     * @todo brake it to: checkPermission, check Environment, setEnvironment, doSpecifics(create/edit)
     */
    public function createController($module, $controller)
    {
        //======================================================================
        // get/check: module path, controller file, controller factory file, module config file
        //======================================================================

        $modulePath = __DIR__ . "/../../../../../../module/$module";
        if(!is_dir($modulePath)){
            throw new \Exception("Module doesnt exist: $modulePath");
        }

        $controllerFile = "$modulePath/src/$module/Controller/{$controller}Controller.php";
        if(is_file($controllerFile)){
            throw new \Exception('Controller already exist');
        }

        $factoryFile = "$modulePath/src/$module/Factory/Controller/{$controller}ControllerFactory.php";
        if(is_file($factoryFile)){
            throw new \Exception('Controller factory already exist');
        }

        $configFile = $modulePath . "/config/module.config.php";
        if(!is_file($configFile)){
            throw new \Exception("Config file doesn't exist: $configFile");
        }

        //======================================================================
        // create controller and factory file and change config
        //======================================================================

        $this->createControllerClass($module, $controller, $controllerFile);
        $this->createControllerFactoryClass($module, $controller, $factoryFile);
        $this->changeModuleConfig($configFile, $this->getControllerFqcnString($controller, $module));
    }

    private function createControllerClass($module, $controller, $controllerFile)
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/ControllerTemplate.txt');
        $template = str_replace(['{{module}}', '{{controller}}'], [$module, $controller], $template);
        file_put_contents($controllerFile, $template);
    }

    private function createControllerFactoryClass($module, $controller, $factoryFile)
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/FactoryTemplate.txt');
        $template = str_replace(['{{module}}', '{{controller}}'], [$module, $controller], $template);
        file_put_contents($factoryFile, $template);
    }

    // Found position where we need to insert new line and insert it
    private function changeModuleConfig($configFile, $strToInsert)
    {
        $str1 = 'controllers';
        $str2 = 'factories';
        $ofs1 = count($str1) + 2;
        $ofs2 = count($str2) + 2;
        $file = file_get_contents($configFile);

        ($p1 = strpos($file, "'$str1'")) || ($p1 = strpos($file, '"' . $str1 . '"'));
        ($p2 = strpos($file, "'$str2'", $p1 + $ofs1)) || ($p2 = strpos($file, '"' . $str2 . '"', $p1 + $ofs1));

        $p3   = strpos($file, ']', $p2 + $ofs2);
        $file = substr_replace($file, $strToInsert, $p3, 0);

        return file_put_contents($configFile, $file);
    }

    private function getControllerFqcnString($controller, $module)
    {
        return "\t'{$module}\\Controller\\{$controller}' => " .
        "'{$module}\\Factory\\Controller\\{$controller}ControllerFactory',\n\t\t";
    }

}