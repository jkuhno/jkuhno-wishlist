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
    private function validReleaseDate($name)
    {
        if($name === false && array_sum($dt->getLastErrors())) {
            return false;
        }
        return true;
    }
    private function validGameName($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = "Missing {$name}!";
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$this->$request->get('name'))) {
            $this->errors[] = "{$name} is not a valid game name";
            return false;
        }
        return true;
    }
    private function validEmail($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = "Missing {$name}!";
            return false;
        }
        if (!filter_var($this->request->get($name), FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "{$name} is not a valid email";
            return false;
        }
        return true;
    }
    private function exists($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = "Missing {$name}!";
            return false;
        }
        if(empty($this->request->get($name))) {
            $this->errors[] = "{$name} was empty!";
            return false;
        }
        return true;
    }
}