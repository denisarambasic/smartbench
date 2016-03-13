<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

//

use Denis\UserBundle\Entity\User;

$user = new User();
$user->setUsername('denis');
$user->setPassword(encodePass($user, 'denispass'));
$user->setRoles(array('ROLE_ADMIN'));
$em = $container->get('doctrine')->getManager();
$em->persist($user);
$em->flush();

function encodePass($user, $plainPassword)
{
	global $container;
	$factory = $container->get('security.encoder_factory');

	$encoder = $factory->getEncoder($user);
	$password = $encoder->encodePassword($plainPassword, $user->getSalt());
	return $password;
}