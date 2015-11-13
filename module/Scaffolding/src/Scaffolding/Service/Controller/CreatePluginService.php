<?php

namespace Scaffolding\Service\Controller;

class CreatePluginService
{
    private $module;
    private $modulePath;
    private $moduleSrcPath;
    private $configFile;
    private $name;
    private $pluginClass;
    private $pluginFactory;

    public function createPlugin($module, $pluginName)
    {
        // set check environment
        $this->setBase($module, $pluginName);
        $this->checkEnvironment();
        $this->setEnvironment();

        // create/edit files
        $this->createFactory();
        $this->createClass();
        $this->editConfig();
    }

    private function setBase($module, $pluginName)
    {
        $this->module        = $module;
        $this->modulePath    = __DIR__ . "/../../../../../../module/$module";
        $this->moduleSrcPath = "$this->modulePath/src/$module";
        $this->configFile    = $this->modulePath . "/config/module.config.php";
        $this->pluginClass   = $pluginName . '.php';
        $this->pluginFactory = $pluginName . 'Factory.php';
        $this->name          = $pluginName;
    }

    private function checkEnvironment()
    {
        if(!is_dir($this->modulePath)){
            throw new \Exception("Module doesnt exist: $this->modulePath");
        }

        if(!is_file($this->configFile)){
            throw new \Exception("Config file doesn't exist: $this->configFile");
        }

        $config = include $this->configFile;
        if(isset($config['controller_plugins']) && isset($config['controller_plugins']['factories']) &&
            isset($config['controller_plugins']['factories'][$this->name])
        ){
            throw new \Exception("Controller Plugin already exist: $this->name");
        }
    }

    private function setEnvironment()
    {
        // create folder structure for class
        is_dir("$this->modulePath/src/$this->module/Controller") ||
        mkdir("$this->modulePath/src/$this->module/Controller");

        is_dir("$this->modulePath/src/$this->module/Controller/Plugin") ||
        mkdir("$this->modulePath/src/$this->module/Controller/Plugin");

        // create folder structure for factory
        is_dir("$this->modulePath/src/$this->module/Factory") ||
        mkdir("$this->modulePath/src/$this->module/Factory");

        is_dir("$this->modulePath/src/$this->module/Factory/Controller") ||
        mkdir("$this->modulePath/src/$this->module/Factory/Controller");

        is_dir("$this->modulePath/src/$this->module/Factory/Controller/Plugin") ||
        mkdir("$this->modulePath/src/$this->module/Factory/Controller/Plugin");

        // set in config file appropriate key for 'controller_plugins' and/or 'factories' - if not exist
        $config = include $this->configFile;
        $file   = file_get_contents($this->configFile);

        if(!isset($config['controller_plugins'])){
            $pos         = strrpos($file, ']') - 1;
            $comma       = substr(trim(substr($file, 0, $pos)), -1) === ',';
            $strToInsert = $this->getControllerPluginConfigString($comma);
            $file        = substr_replace($file, $strToInsert, $pos, 0);

            file_put_contents($this->configFile, $file);
        }elseif(!isset($config['controller_plugins']['factories'])){
            ($p = strpos($file, "'controller_plugins'")) || ($p = strpos($file, '"controller_plugins"'));
            $p2   = strpos($file, '[', $p + count("'controller_plugins'"));
            $file = substr_replace($file, $this->getFactoriesConfigString(), $p2 + 1, 0);

            file_put_contents($this->configFile, $file);
        }
    }

    private function createFactory()
    {
        $file     = "$this->moduleSrcPath/Factory/Controller/Plugin/$this->pluginFactory";
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/Plugin/PluginFactoryTemplate.txt');
        $template = str_replace(['{{module}}', '{{name}}'], [$this->module, $this->name], $template);
        file_put_contents($file, $template);
    }

    private function createClass()
    {
        $file     = "$this->moduleSrcPath/Controller/Plugin/$this->pluginClass";
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/Plugin/PluginTemplate.txt');
        $template = str_replace(['{{module}}', '{{name}}'], [$this->module, $this->name], $template);
        file_put_contents($file, $template);
    }

    private function editConfig()
    {
        $str1 = 'controller_plugins';
        $str2 = 'factories';
        $ofs1 = count($str1) + 2;
        $ofs2 = count($str2) + 2;
        $file = file_get_contents($this->configFile);

        ($p1 = strpos($file, "'$str1'")) || ($p1 = strpos($file, '"' . $str1 . '"'));
        ($p2 = strpos($file, "'$str2'", $p1 + $ofs1)) || ($p2 = strpos($file, '"' . $str2 . '"', $p1 + $ofs1));

        $p3   = strpos($file, ']', $p2 + $ofs2);
        $file = substr_replace($file,  $this->getConfigString(), $p3, 0);

        return file_put_contents($this->configFile, $file);
    }

    private function getConfigString()
    {
        $template = "\t'{{name}}' => '\\{{module}}\\Factory\\Controller\\Plugin\\{{factory}}',\n\t\t";

        return str_replace(
            ['{{name}}', '{{module}}', '{{factory}}'],
            [$this->name, $this->module, $this->name . 'Factory'],
            $template
        );
    }

    private function getControllerPluginConfigString($comma = true)
    {
        $comma = ($comma ? '' : ',');

        return "$comma
    'controller_plugins' => [
        'factories' => [
        ]
    ],";
    }

    private function getFactoriesConfigString()
    {
        return "
        'factories' => [
        ],
        ";
    }

}