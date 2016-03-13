<?php

namespace Denis\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
	
		$em = $this->getDoctrine()->getManager();
		
		//$userRepo = $em->getRepository('UserBundle:User');
		//var_dump($userRepo->findOneByUsernameOrEmail('denis.arambasic@gmail.com'));die;
        return $this->render('UserBundle:Default:index.html.twig');
    }
	
	public function zasticenoAction()
	{
		var_dump('Ode samo ako si logiran');die;
	}
	
}
