<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BanWordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BanWord $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $value = strtolower($value);
        foreach($constraint->banWords as $banWord){
            if(str_contains($value, $banWord)){ // Si la chaine de caractères 'value' elle contient des mots bannis
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ banWord }}', $banWord)
                ->addViolation(); // Build violation qui affiche le message a afficher
            } 
        }
    }
}
