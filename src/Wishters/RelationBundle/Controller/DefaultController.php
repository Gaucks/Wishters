<?php

namespace Wishters\RelationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WishtersRelationBundle:Default:index.html.twig', array('name' => $name));
    }
}
