<?php
namespace Scaffolding\Controller;

use Scaffolding\Service\Common\Util;
use Scaffolding\Service\Module\CreateModuleService;
use Zend\Console\Adapter\Posix;
use Zend\Console\ColorInterface as Color;
use Zend\Mvc\Controller\AbstractActionController;
use \Exception;

class ModuleController extends AbstractActionController {

    /** @var  CreateModuleService $createModuleService */
    private $createModuleService;

    /** @var  Posix $console */
    private $console;

    /**
     * ModuleController constructor.
     * @param CreateModuleService $createModuleService
     * @param Posix $console
     */
    public function __construct(CreateModuleService $createModuleService, Posix $console) {
        $this->createModuleService = $createModuleService;
        $this->console = $console;
    }

    public function createModuleAction() {
        $request = $this->getRequest();
        $module = $request->getParam('module');
        $mvc = $request->getParam('mvc');
        $this->createModuleService->create($module, $mvc);
        $this->console->write(Util::format("Module {$module} is created!"), Color::GREEN);
    }

    public function removeModuleAction() {
        try{
            $request = $this->getRequest();
            $module = $request->getParam('module');
            $this->createModuleService->remove($module);
            $this->console->write(Util::format("Module {$module} is removed!"), Color::GREEN);
        } catch (Exception $e) {
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }
}