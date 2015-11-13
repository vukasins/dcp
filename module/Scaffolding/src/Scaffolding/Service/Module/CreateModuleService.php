<?php

namespace Scaffolding\Service\Module;
use Wallet\Common\Util;

class CreateModuleService
{
    public function create($name, $isMvc)
    {
        $moduleCreate = new CreateModule($name, $isMvc);
        return $moduleCreate->create();
    }

    public function remove($name) {
        $path = __DIR__ . "/../../../../../" . ucfirst($name);
        return Util::deleteDirectory($path);
    }
}