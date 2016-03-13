<?php

namespace Denis\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', 'text')
			->add('email', 'text')
			->add('password', 'repeated', array(
				'type' => 'password',
				'invalid_message' => 'The password fields must match.'
				));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Denis\UserBundle\Entity\User'
		));
	}

	public function getName()
	{
		return 'user_register';
	}

}