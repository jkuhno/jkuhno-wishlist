<?php
namespace Wishlist\Core;
use Wishlist\Core\App;
class Validator
{
    protected $validables = [];
    protected $errors = [];
    protected $request;
    public function __construct($data)
    {
        $this->validables = $data;
        $this->request = App::get('request')->request;
    }
    public function validate()
    {
        foreach ($this->validables as $name => $rule) {
            if(!method_exists($this, $rule)) {
                throw new \Exception("No validator method {$rule} present.");
            }
            $this->$rule($name);
        }
        return $this->errors;
    }
    private function validEmail($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = "The variable {$name} did not exist";
            return false;
        }
        if (!filter_var($this->request->get($name), FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "The variable {$name} is not a valid email";
            return false;
        }
        return true;
    }
    private function required($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = "The variable {$name} did not exist";
            return false;
        }
        if(empty($this->request->get($name))) {
            $this->errors[] = "The variable {$name} was empty";
            return false;
        }
        return true;
    }
}