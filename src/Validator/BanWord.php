<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWord extends Constraint
{
    public function __construct(
        public string $message = 'Le mot "{{ banWord }}" est innaproprié', 
        public array $banWords = ['spam', 'viagra'],
        ?array $groups = null, // Tableau qui va contenir les groupes
        mixed $payload = null // Envoyer au constructeur parent
        )
    {
        parent::__construct(null, $groups, $payload); // Appeler le constructeur parent
    }
}
