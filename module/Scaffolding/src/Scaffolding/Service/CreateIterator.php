<?php
namespace Scaffolding\Service;

class CreateIterator
{
    private $list;

    public function __construct()
    {
        $list = [];
    }

    public function add(CreateInterface $create)
    {
        $this->list[] = $create;
        return $this;
    }

    public function execute()
    {
        /** @var CreateInterface $creator */
        foreach($this->list as $creator)
        {
            $creator->create();
        }
    }
}