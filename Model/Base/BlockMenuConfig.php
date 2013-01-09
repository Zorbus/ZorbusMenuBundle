<?php

namespace Zorbus\MenuBundle\Model\Base;

use Zorbus\BlockBundle\Model\BlockConfig;

abstract class BlockMenuConfig extends BlockConfig
{
    protected $httpKernel;
    protected $em;

    public function getMenusAsArray()
    {
        $objects = $this->em->getRepository('ZorbusMenuBundle:Menu')->findAll();
        $menus = array();
        foreach ($objects as $menu) {
            $menus[$menu->getId()] = $menu->getTitle();
        }

        return $menus;
    }

}
