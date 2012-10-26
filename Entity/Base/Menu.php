<?php

namespace Zorbus\MenuBundle\Entity\Base;

/**
 * Zorbus\MenuBundle\Entity\Menu
 */
abstract class Menu
{
    public function __toString()
    {
        return $this->getTitle();
    }
}