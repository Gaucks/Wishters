<?php

namespace Wishters\TutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WishtersTutoBundle:Default:index.html.twig', array('name' => $name));
    }
}
