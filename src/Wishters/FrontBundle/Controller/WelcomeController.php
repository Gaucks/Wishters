<?php

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('WishtersFrontBundle:Welcome:index.html.twig');
    }
}
