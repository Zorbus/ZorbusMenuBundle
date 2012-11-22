<?php

namespace Zorbus\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Image;

class ItemAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('constraints' => array(
                        new NotBlank(),
                        new MaxLength(array('limit' => 255))
                    )
                ))
                ->add('url', null, array('constraints' => array(
                        new NotBlank(),
                        new Url()
                    )
                ))
                ->add('menu', null, array(
                    'required' => true,
                    'attr' => array('class' => 'span5 select2'),
                    'constraints' => array(
                        new NotBlank(),
                        new Type(array('type' => 'Zorbus\MenuBundle\Entity\Menu'))
                    )
                ))
                ->add('parent', null, array(
                    'required' => false,
                    'attr' => array('class' => 'span5 select2'),
                    'constraints' => array(
                        new Type(array('type' => 'Zorbus\MenuBundle\Entity\Item'))
                    )
                ))
                ->add('description', 'textarea', array('required' => false, 'attr' => array('class' => 'ckeditor')))
                ->add('imageTemp', 'file', array(
                    'required' => false,
                    'label' => 'Image',
                    'constraints' => array(
                        new Image()
                    )
                ))
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

    public function prePersist($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

}