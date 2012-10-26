<?php

namespace Zorbus\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZorbusMenuBundle:Default:index.html.twig', array('name' => $name));
    }
}
