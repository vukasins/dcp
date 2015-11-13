<?php
namespace Scaffolding\Service\Entity;

use Scaffolding\Service\CreateInterface;

interface CreateEntityInterface extends CreateInterface
{
    public function createGetters();

    public function createSetters();

    public function createProperties();
}