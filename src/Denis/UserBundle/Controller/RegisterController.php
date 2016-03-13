<?php

namespace Denis\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Denis\UserBundle\Form\RegisterFormType;
use Denis\UserBundle\Entity\User;

class RegisterController extends Controller
{
   /**
    * @Route("/register", name="user_register")
    * @Template()
	*/
   public function registerAction(Request $request)
   {
   
		$form = $this->createForm(new RegisterFormType());
			
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$user = $form->getData();
			$user->setPassword($this->encodePassword($user, $user->getPassword()));
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			$request->getSession()->getFlashbag()
				->add('success', 'You are registered, and can now login with your credentials!');
			
			$url = $this->generateUrl('login');
			return $this->redirect($url);
			
		}
			
		return array('form' => $form->createView())	;
   
   }
   
   private function encodePassword(User $user, $plainPassword)
   {
		$encoder = $this->container->get('security.encoder_factory')
			->getEncoder($user);
		
		return $encoder->encodePassword($plainPassword, $user->getSalt());
			
   }
	
}
