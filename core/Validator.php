<?php
namespace Wishlist\Core;

use \DateTime;
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
        $dt = DateTime::createFromFormat("F d, Y", $this->request->get($name));
        if($dt === false || array_sum($dt->getLastErrors())) {
            $this->errors[] = $this->request->get($name) . " is invalid! Please use correct date format, e.g. January 24, 2017!";
            return false;
        }
        return true;
    }
    private function validGameName($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = ucfirst($name) . " missing!";
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9_~\-:;.,+?!@#\$%\^&\*\'"\(\)\/\\\\ ]+$/',$this->request->get($name))) {
            $this->errors[] = $this->request->get($name) . " is not a valid name!";
            return false;
        }
        return true;
    }
    private function validEmail($name)
    {
        if(!$this->request->has($name)) {
            $this->errors[] = ucfirst($name) . " missing!";
            return false;
        }
        if (!filter_var($this->request->get($name), FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = $this->request->get($name) . " is not a valid email!";
            return false;
        }
        return true;
    }
    private function exists($name)
    {
        if(!$this->request->has($name)) {

            $this->errors[] = ucfirst($name) . " missing!";
            return false;
        }
        if(empty($this->request->get($name))) {
            $this->errors[] = ucfirst($name) . " is required!";
            return false;
        }
        return true;
    }
}