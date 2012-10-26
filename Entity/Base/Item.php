<?php

namespace Zorbus\MenuBundle\Entity\Base;

/**
 * Zorbus\MenuBundle\Entity\Item
 */
abstract class Item
{
    public function __toString()
    {
        return $this->getName();
    }
}