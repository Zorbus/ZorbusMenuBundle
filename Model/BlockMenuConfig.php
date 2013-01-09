<?php

namespace Zorbus\MenuBundle\Model;

use Zorbus\BlockBundle\Entity\Block as BlockEntity;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\Form\FormFactory;

class BlockMenuConfig extends Base\BlockMenuConfig
{

    public function __construct(AdminInterface $admin, FormFactory $formFactory, $httpKernel, $em)
    {
        parent::__construct('zorbus_menu.block.menu', 'Menu Block', $admin, $formFactory);
        $this->enabled = true;
        $this->themes = array('ZorbusMenuBundle:Block:default' => 'Default');
        $this->httpKernel = $httpKernel;
        $this->em = $em;
    }

    public function getFormMapper()
    {
        return $this->formMapper
                ->add('menu_id', 'choice', array(
                    'choices' => $this->getMenusAsArray(),
                    'attr' => array('class' => 'span5 select2')
                ))
                ->add('name', 'text')
                ->add('lang', 'text', array('required' => false))
                ->add('theme', 'choice', array(
                    'choices' => $this->getThemes(),
                    'attr' => array('class' => 'span5 select2')
                ))
                ->add('cache_ttl', 'integer', array(
                    'required' => false,
                    'attr' => array('class' => 'span2')
                ))
                ->add('enabled', 'checkbox', array('required' => false))
        ;
    }

    public function getBlockEntity(array $data, BlockEntity $block = null)
    {
        $block = null === $block ? new BlockEntity() : $block;

        $block->setService($this->getService());
        $block->setCategory('Menu');
        $block->setParameters(json_encode(array('menu_id' => $data['menu_id']->getId())));
        $block->setName($data['name']);
        $block->setLang($data['lang']);
        $block->setTheme($data['theme']);
        $block->setEnabled((boolean) $data['enabled']);
        $block->setCacheTtl($data['cache_ttl']);

        return $block;
    }

    public function render(BlockEntity $block, $page = null, $request = null)
    {
        if ($block->getService() != $this->getService()) {
            throw new \InvalidArgumentException('Block service not supported');
        }

        return $this->httpKernel->forward($block->getTheme(), array('block' => $block, 'page' => $page, 'request' => $request));
    }

}