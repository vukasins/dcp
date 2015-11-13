<?php
namespace Scaffolding\Service\Controller;

use \Scaffolding\Service\Common\Util;

/**
 * @todo REFACTOR ALL
 */
class CreateActionService
{

    /**
     * We are doing 2 part:
     * 1. check enviroment
     * 2. create/cgange files on file system
     *
     * @todo brake it to: checkPermission, check Environment, setEnvironment, doSpecifics(create/edit)
     */
    public function createAction($module, $controller, $action)
    {
        //======================================================================
        // get/check: module path, controller file, route-module config file.
        // check if action exist and check if 'routes' exist
        //======================================================================

        $modulePath = __DIR__ . "/../../../../../../module/$module";
        if(!is_dir($modulePath)){
            throw new \Exception("Module doesnt exist: $modulePath");
        }

        $controllerFile = "$modulePath/src/$module/Controller/{$controller}Controller.php";
        if(!is_file($controllerFile)){
            throw new \Exception("Controller doesn't exist");
        }

        $configFile = $modulePath . "/config/route.config.php"; //@todo check in module.config first
        if(!is_file($configFile)){
            throw new \Exception("Config file doesn't exist: $configFile");
        }

        if($this->isActionExist($controllerFile, $action)){
            throw new \Exception("Action in controller already exist");
        }

        if(!$this->isRouteConfig($configFile)){
            throw new \Exception("In config file there is no 'routes' key");
        }

        $viewPath = $this->setViewEnv($modulePath, $module, $controller, $action);

        //======================================================================
        // change controller and route-config files
        //======================================================================
        $this->addAction($controllerFile, $this->getActionString($action));
        $this->addRoute($configFile, $this->getRouteString($module, $controller, $action));
        $this->createViewFile($viewPath, $module, $controller, $action);
    }

    private function setViewEnv($modulePath, $module, $controller, $action)
    {
        $action   = Util::toDashes($action);
        $viewPath = $modulePath . '/view/' . Util::toDashes($module);

        if(!is_dir($viewPath)){
            mkdir($viewPath);
        }

        $viewPath .= '/' . Util::toDashes($controller);

        if(!is_dir($viewPath)){
            mkdir($viewPath);
        }

        if(is_file("$viewPath/$action.phtml")){
            throw new \Exception("View file already exist: $viewPath/$action.phtml");
        }

        return $viewPath;
    }

    private function isRouteConfig($configFile)
    {
        $file = file_get_contents($configFile);

        return preg_match("/['|\"]routes['|\"][\\s]*=>[\\s]*(\\[|array)/", $file);
    }

    private function isActionExist($controllerFile, $action)
    {
        $file = file_get_contents($controllerFile);

        return (strpos($file, "public function {$action}Action") !== false);
    }

    private function addAction($controllerFile, $strToInsert)
    {
        $file = file_get_contents($controllerFile);
        $pos  = strrpos($file, '}') - 1;
        $file = substr_replace($file, $strToInsert, $pos, 0);

        return file_put_contents($controllerFile, $file);
    }

    private function createViewFile($viewPath, $module, $controller, $action)
    {
        $action   = Util::toDashes($action);
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/ViewTemplate.txt');
        $template = str_replace(['{module}', '{controller}', '{action}'], [$module, $controller, $action], $template);
        file_put_contents("$viewPath/$action.phtml", $template);
    }

    private function addRoute($configFile, $strToInsert)
    {
        $str  = 'routes';
        $ctn  = count($str) + 2;
        $file = file_get_contents($configFile);

        ($p = strpos($file, "'$str'")) || ($p = strpos($file, '"' . $str . '"'));
        $p2   = strpos($file, '[', $p + $ctn);
        $file = substr_replace($file, $strToInsert, $p2 + 1, 0);

        return file_put_contents($configFile, $file);
    }

    private function getActionString($action)
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/ActionTemplate.txt');

        return str_replace('{action}', $action, $template);
    }

    private function getRouteString($module, $controller, $action)
    {
        $route    = strtolower($module . '-' . $controller) . '-' . Util::toDashes($action);
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/RouteTemplate.txt');
        $replace  = ['{route}', '{module}', '{controller}', '{action}'];
        $with     = [$route, $module, $controller, $action];
        $template = str_replace($replace, $with, $template);

        return $template;
    }

}