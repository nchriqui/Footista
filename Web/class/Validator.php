<?php
namespace Foot;

use DateTime;
use Foot\Table\Table;

class Validator {

    private $data;

    protected $errors = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function validates(array $data)
    {
        $this->errors = [];
        $this->data = $data;
        return $this->errors;
    }

    public function validate(string $field, string $method, ...$parameters)
    {
        if(empty($this->data[$field])) {
            $this->errors[$field] = "Le champ $field n'est pas rempli";
            return false;
        } 
        else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function date(string $field)
    {
        if (DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field] = "La date n'est pas valide";
            return false;
        }
        return true;
    }
}
?>