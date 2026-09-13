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
    public function SupplierValidation(array $data):array
    {
        $schema=v::key('company_name',v::stringType()->notEmpty()->length(3,255))
        ->key('phone_no',v::stringType()->notEmpty()->length(10,10))
        // ->key('alternate_phone_no',v::stringType()->length(10,10))
        ->key('email',v::stringType()->notEmpty()->email())
        ->key('pincode',v::notEmpty()->length(6,6))
        ->key('address',v::stringType()->notEmpty()->length(3,255))
        ->key('city',v::stringType()->notEmpty()->length(3,50))
        ->key('state',v::stringType()->notEmpty()->length(3,50))
        ->key('country',v::stringType()->notEmpty()->length(3,50))
        ->key('GST_no',v::notEmpty()->length(0,15));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
     public function Main_category(array $data):array
    {
        $schema=v::key('name',v::stringType()->notEmpty()->length(1,255));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
     public function UOMValidation(array $data):array
    {
        $schema=v::key('unit_of_measurement',v::stringType()->notEmpty()->length(3,255));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
     public function LocationValidation(array $data):array
    {
        $schema=v::key('name',v::stringType()->notEmpty()->length(3,255));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }

    public function Pobill(array $data):array
    {
        $schema=v::key('invoice_no',v::stringType()->notEmpty()->length(1,400))
        ->key('total_quantity',v::notEmpty()->length(1))
        ->key('total_price',v::notEmpty()->length(1))
        ->key('transaction_ref_no',v::stringType()->notEmpty()->length(1))
        ->key('total_taxable_value',v::notEmpty()->length(1))
        ->key('grand_total',v::notEmpty()->length(1))
        ->key('notes',v::stringType()->notEmpty()->length(3,50))
        ->key('bill_date',v::notEmpty()->length(0,15))
        ->key('payment_date',v::notEmpty()->length(0,15));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }

     public function PolossesValidation(array $data):array
    {
        $schema=v::key('loss_quantity',v::notEmpty()->length(1,10))
        ->key('loss_amount',v::notEmpty()->length(1,15));
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }

    public function PoPurchaseReturnValidation(array $data):array
    {
        $schema=v::key('quantity',v::notEmpty()->length(1,255))
        ->key('purchase_price',v::notEmpty()->length(1,255))
        ->key('remain_amount',v::notEmpty()->length(1,255))
        ->key('transaction_ref_no',v::stringType()->notEmpty()->length(3,255))
        ->key('payment_date',v::notEmpty());
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
    public function PoItems(array $data):array
    {
        
        $schema=v::key('quantity',v::notEmpty()->length(1,255))
        ->key('product_name',v::stringType()->notEmpty()->length(3,255))
        ->key('purchase_price',v::notEmpty()->length(1,255))
        ->key('total_price',v::notEmpty()->length(1,255))
        ->key('purchase_date',v::notEmpty());
        try{
            $schema->assert($data);
            return [];
        }
        catch (\Respect\Validation\Exceptions\NestedValidationException $e) {
            return $e->getMessages();
        }
    }
    public function PoStockOut(array $data):array
    {
        
        $schema=v::key('quantity',v::notEmpty()->length(1,255))
        ->key('stock_out_date',v::notEmpty());
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