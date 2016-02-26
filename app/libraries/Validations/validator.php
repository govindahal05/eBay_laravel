<?php
namespace Libraries\Validations;
class Validator{
    public function validate($validate, $rules) {
        $validation = \Validator::make(
            $validate,
            $rules
        );
        if ( $validation->fails() ) {
            //return $validation->messages();
            return $validation;
        }
        return true;
    }
}