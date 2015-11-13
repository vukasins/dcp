<?php

namespace Scaffolding\Service\Controller;

class CreateHelperService
{
    private $module;
    private $modulePath;
    private $moduleSrcPath;
    private $configFile;
    private $name;
    private $helperClass;
    private $helperFactory;

    public function createHelper($module, $helperName)
    {
        // set check environment
        $this->setBase($module, $helperName);
        $this->checkEnvironment();
        $this->setEnvironment();

        // create/edit files
        $this->createFactory();
        $this->createClass();
        $this->editConfig();
    }

    private function setBase($module, $helperName)
    {
        $this->module        = $module;
        $this->modulePath    = __DIR__ . "/../../../../../../module/$module";
        $this->moduleSrcPath = "$this->modulePath/src/$module";
        $this->configFile    = $this->modulePath . "/config/module.config.php";
        $this->helperClass   = $helperName . '.php';
        $this->helperFactory = $helperName . 'Factory.php';
        $this->name          = $helperName;
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
        if(isset($config['view_helpers']) && isset($config['view_helpers']['factories']) &&
            isset($config['view_helpers']['factories'][$this->name])
        ){
            throw new \Exception("View Helper already exist: $this->name");
        }
    }

    private function setEnvironment()
    {
        // create folder structure for class
        is_dir("$this->modulePath/src/$this->module/View") || mkdir("$this->modulePath/src/$this->module/View");
        is_dir("$this->modulePath/src/$this->module/View/Helper") || mkdir("$this->modulePath/src/$this->module/View/Helper");

        // create folder structure for factory
        is_dir("$this->modulePath/src/$this->module/Factory") || mkdir("$this->modulePath/src/$this->module/Factory");
        is_dir("$this->modulePath/src/$this->module/Factory/View") || mkdir("$this->modulePath/src/$this->module/Factory/View");
        is_dir("$this->modulePath/src/$this->module/Factory/View/Helper") || mkdir("$this->modulePath/src/$this->module/Factory/View/Helper");

        // set in config file appropriate key for 'view_manager' and/or 'factories' - if not exist
        $config = include $this->configFile;
        $file   = file_get_contents($this->configFile);

        if(!isset($config['view_helpers'])){
            $pos         = strrpos($file, ']') - 1;
            $comma       = substr(trim(substr($file, 0, $pos)), -1) === ',';
            $strToInsert = $this->getViewHelperConfigString($comma);
            $file        = substr_replace($file, $strToInsert, $pos, 0);

            file_put_contents($this->configFile, $file);
        }
        elseif(!isset($config['view_helpers']['factories'])){
            ($p = strpos($file, "'view_helpers'")) || ($p = strpos($file, '"view_helpers"'));
            $p2   = strpos($file, '[', $p + count("'view_helpers'"));
            $file = substr_replace($file, $this->getFactoriesConfigString(), $p2 + 1, 0);

            file_put_contents($this->configFile, $file);
        }
    }

    private function createFactory()
    {
        $file     = "$this->moduleSrcPath/Factory/View/Helper/$this->helperFactory";
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/Helper/HelperFactoryTemplate.txt');
        $template = str_replace(['{{module}}', '{{name}}'], [$this->module, $this->name], $template);
        file_put_contents($file, $template);
    }

    private function createClass()
    {
        $file     = "$this->moduleSrcPath/View/Helper/$this->helperClass";
        $template = file_get_contents(__DIR__ . '/../../../../template/Controller/Helper/HelperTemplate.txt');
        $template = str_replace(['{{module}}', '{{name}}'], [$this->module, $this->name], $template);
        file_put_contents($file, $template);
    }


    private function editConfig()
    {
        $str1 = 'view_helpers';
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
        $template = "\t'{{name}}' => '\\{{module}}\\Factory\\View\\Helper\\{{factory}}',\n";

        return str_replace(
            ['{{name}}', '{{module}}', '{{factory}}'],
            [$this->name, $this->module, $this->name . 'Factory'],
            $template
        );
    }

    private function getFactoriesConfigString()
    {
        return "
        'factories' => [
        ],
        ";
    }

    private function getViewHelperConfigString($comma = true)
    {
        $comma = ($comma ? '' : ',');

        return "$comma
    'view_helpers' => [
        'factories' => [
        ]
    ],";
    }

}