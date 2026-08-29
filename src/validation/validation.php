<?php

namespace src\validation;
use Respect\Validation\Validator as v;

class validation{
    public static function UserValidation ( array $data):array
    {
        $schema=v::key('full_name',v::stringType()->notEmpty()->length(3,255))
        ->key('email',v::stringType()->notEmpty()->email())
        ->key('password',v::stringType()->notEmpty()->length(3,100))
        ->key('phone_no',v::stringType()->notEmpty()->length(10,10))
        ->key('company_name',v::stringType()->notEmpty()->length(3,100))
        ->key('business_type_id',v::stringType()->notEmpty())
        ->key('country_name',v::stringType()->notEmpty()->length(3,100))
        ->key('state_name',v::stringType()->notEmpty()->length(3,50))
        ->key('city_name',v::stringType()->notEmpty()->length(3,50));
        try {
            $schema->assert($data);

            return [];
        } catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
    public function AuthValidation(array $data):array
    {
         $schema=v::key('full_name',v::stringType()->notEmpty()->length(3,255))
        ->key('email',v::stringType()->notEmpty()->email());
        try {
            $schema->assert($data);

            return [];
        } catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
    public function BussinessValidation(array $data):array
    {
        $schema=v::key('busines_type',v::stringType()->notEmpty()->length(3,255));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
    
}




?>