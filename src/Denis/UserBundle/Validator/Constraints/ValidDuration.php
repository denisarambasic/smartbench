<?php
namespace Denis\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidDuration extends Constraint
{
    public $message = 'Movie duration is "%string%", you can only upload max 10sec .';
}