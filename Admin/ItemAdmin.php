<?php
namespace Zorbus\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ItemAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('url')
            ->add('menu', null, array('required' => true, 'attr' => array('class' => 'span5 select2')))
            ->add('parent', null, array('required' => false, 'attr' => array('class' => 'span5 select2')))
            ->add('description', 'textarea', array('required' => false, 'attr' => array('class' => 'ckeditor')))
            ->add('imageTemp', 'file', array('required' => false, 'label' => 'Image'))
            ->add('enabled', null, array('required' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('menu')
            ->add('parent')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('menu')
            ->addIdentifier('parent')
            ->add('enabled')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
                ->assertNotBlank()
                ->assertMaxLength(array('limit' => 255))
            ->end()
            ->with('url')
                ->assertNotBlank()
                ->assertMaxLength(array('limit' => 255))
            ->end()
            ->with('menu')
                ->assertNotBlank()
            ->end()
        ;
    }
    public function prePersist($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }
}