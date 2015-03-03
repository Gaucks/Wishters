<?php

namespace Wishters\BlogBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Wishters\BlogBundle\Entity\Post;
use Wishters\BlogBundle\Form\PostType;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('WishtersBlogBundle:Blog:index.html.twig');
    }

    public function showMyBlogAction(Request $request)
    {

        $post = new Post();
        $form = $this->createForm(new PostType(), $post);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('WishtersBlogBundle:Post');

        $blog = $repository->findBy(array(), array('date' => 'desc'));

        return $this->render('WishtersBlogBundle:Blog:index.html.twig', array('form' => $form->createView(),'posts' => $blog));
    }

    public function postTraitementAction(Request $request)
    {

        if($request->isXmlHttpRequest()) {

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }

            $post = new Post();

            $form = $this->createForm(new PostType(), $post);

            $post->setUser($user);

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($post);
                $em->flush();

                // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
                $response = new JsonResponse();
                $response->setData(array('content' => 'ok'));

                // Ici, nous définissons le Content-type pour dire que l'on renvoie du JSON et non du HTML

                $response->headers->set('Content-Type', 'application/json');

                return $response;

            }

            return new Response('Oups y\'a un bug la');
        }

        return new Response('Oups y\'a un bug la');

    }

    public function showMyBlogPosts()
    {

    }

    public function fadePostsAction(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('WishtersBlogBundle:Post');

            $post = $repository->find($request->attributes->get('id'));

            if($post){
                $em->remove($post);
                $em->flush();
            }
            else{
                return new Response('Ce post n\'existe pas...');
            }


            // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
            $response = new JsonResponse();
            // Ici, nous définissons le Content-type pour dire que l'on renvoie du JSON et non du HTML
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }

        return new Response('Cette requete ne peut pas être exécutée directement...');
    }

    public function morePostsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $repository = $this->getDoctrine()->getManager()->getRepository('WishtersBlogBundle:Blog');
            $message   = $repository->findAll();

            // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
            $response = new JsonResponse();
            $response->setData();
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }


}
