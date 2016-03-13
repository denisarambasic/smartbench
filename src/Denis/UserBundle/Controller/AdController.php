<?php

namespace Denis\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Denis\UserBundle\Entity\Ad;

class AdController extends Controller
{
	/**
	 * @Template
	 * @Route("/zasticeno", name="zasticeno")
	 */
    public function indexAction(Request $request)
    {
	
		$ad = new Ad(); 
	
		$form = $this->createFormBuilder($ad)
				->add('location', 'choice', array(
					'choices'   => array(
					'Split'   => 'Split',
					'Solin' => 'Solin',
					'Trogir'   => 'Trogir',
				)
				))
				->add('file','file')
				->getForm();
				
		$form->handleRequest($request);
		
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		
		if($form->isValid())
		{
			
			$ad = $form->getData();
			if($this->validLocation($ad->getLocation()))
			{
				$form->get('location')->addError(new FormError('You can\'t advertise youre self two times for the same location'));
			}else
			{
			$ad->setUser($user);

			
			$em->persist($ad);
			$em->flush();
			}
		}	
		
		$videos = $em->getRepository('UserBundle:Ad')->findByUser($user);
		
		
		
		return array('form' => $form->createView(), 'videos' => $videos);
    }
	
	/**
	 * @Template
	 * @Route("city/{city}", name="show_video")
	 */
    public function showVideoAction($city)
    {
		//var_dump($city);
		$em = $this->getDoctrine()->getManager();
		$videos = $em->getRepository('UserBundle:Ad')->findByLocation($city);
		if (!$videos) {
			throw $this->createNotFoundException('The are not videos for the city ' . $city);
		}
		
		return array('videos'=>$videos, 'city'=>$city);

	
	}
	
	public function validLocation($location)
	{
		
		$em = $this->getDoctrine()->getManager();
		
		$repo = $em->getRepository('UserBundle:Ad');
		return $repo->repeatCity($this->container, $location);

	}


	
}
