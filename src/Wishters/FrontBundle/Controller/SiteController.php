<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 24/02/15
 * Time: 14:06
 */

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller{

    public function indexAction()
    {
        return $this->render('WishtersFrontBundle:Site:index.html.twig');
    }

}