<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 2.11.15.
 * Time: 15.26
 */
namespace Scaffolding\Service\Service;

class CreateServiceService
{
    private $module = '';
    private $namespace = '';
    private $serviceName = '';

    public function __construct()
    {

    }

    public function createService($module, $namespace, $serviceName)
    {
        $this->module = $module;
        $this->namespace = $namespace;
        $this->serviceName = $serviceName;

        $filePath = $this->getServiceFilePath();

        if (is_file($filePath)) {
            throw new \Exception('Service "' . $this->serviceName . '" already exist');;
        }

        if (!$this->checkDirectory(dirname($filePath))) {
            throw new \Exception('Can\t create service directory');;
        }

        $template = file_get_contents(__DIR__ . '/../../../../template/Service/ServiceTemplate.txt');
        $template = str_replace('{{namespace}}', $this->namespace, $template);
        $template = str_replace('{{className}}', $this->serviceName, $template);

        file_put_contents($filePath, $template);

        $this->createFactory();
        $this->registerService();

        return true;
    }

    private function createFactory()
    {
        $filePath = $this->getFactoryFilePath();

        if (is_file($filePath)) {
            throw new \Exception('Service factory for service "' . $this->serviceName . '" already exist');;
        }

        if (!$this->checkDirectory(dirname($filePath))) {
            throw new \Exception('Can\t create factory directory');;
        }

        $template = file_get_contents(__DIR__ . '/../../../../template/Service/FactoryTemplate.txt');
        $template = str_replace('{{serviceNamespace}}', $this->namespace, $template);
        $template = str_replace('{{serviceName}}', $this->serviceName, $template);
        $template = str_replace('{{namespace}}', $this->getFactoryNamespace(), $template);

        file_put_contents($filePath, $template);
    }

    private function getServiceFilePath()
    {
        $moduleDirectory = getcwd() . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $this->module;
        $serviceDirectory = DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $this->namespace . DIRECTORY_SEPARATOR . $this->serviceName . '.php';

        return str_replace('\\', DIRECTORY_SEPARATOR, $moduleDirectory . $serviceDirectory);
    }

    private function getFactoryFilePath()
    {
        $factoryNamespace = $this->getFactoryNamespace();
        $moduleDirectory = getcwd() . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $this->module;
        $factoryDirectory = DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $factoryNamespace . DIRECTORY_SEPARATOR . $this->serviceName . 'Factory.php';

        return str_replace('\\', DIRECTORY_SEPARATOR, $moduleDirectory . $factoryDirectory);
    }

    private function getFactoryNamespace()
    {
        $namespaceParts = explode('\\', $this->namespace);
        $namespaceParts[1] = 'Factory\\Service'; // asumption; must be changed
        return implode('\\', $namespaceParts);
    }

    private function checkDirectory($serviceDirectory)
    {
        if (!is_dir($serviceDirectory . DIRECTORY_SEPARATOR)) {
            if (mkdir($serviceDirectory, true)) {
                return chmod($serviceDirectory, 0755);
            }

            return false;
        }

        return true;
    }

    public function registerService()
    {
        $configFile = getcwd() . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $this->module . "/config/module.config.php";
        $serviceName = $this->namespace . '\\' . $this->serviceName;
        $factoryName = $this->getFactoryNamespace() . '\\' . $this->serviceName;

        $strToInsert = "\t'{$serviceName}' => '{$factoryName}',\n\t";

        $str1 = 'service_manager';
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
}