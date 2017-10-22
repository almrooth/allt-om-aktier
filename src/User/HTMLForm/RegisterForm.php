<?php

namespace App\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\User\User;

/**
 * Example of FormModel implementation.
 */
class RegisterForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "use_fieldset" => false,
            ],
            [
                "username" => [
                    "type"          => "text",
                    "label"         => "Användarnamn",
                    "validation"    => ["not_empty"],
                ],
                        
                "password" => [
                    "type"          => "password",
                    "label"         => "Lösenord",
                    "validation"    => ["not_empty"],
                ],

                "password_confirmation" => [
                    "type"          => "password",
                    "label"         => "Bekräfta lösenord",
                    "validation"    => ["not_empty"],
                ],

                "email" => [
                    "type"          => "email",
                    "label"         => "E-post",
                    "validation"    => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Registrera",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "btn btn-green"
                ],
            ]
        );
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $username       = $this->form->value("username");
        $password       = $this->form->value("password");
        $password2      = $this->form->value("password_confirmation");
        $email          = $this->form->value("email");

        // Check password matches
        if ($password !== $password2) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Check if username is taken
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);
        
        if (isset($user->id)) {
            $this->form->addOutput("Username already taken.");
            return false;
        }

        // Save user to database
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->role         = "user";
        $user->username     = $username;
        $user->email        = $email;
        $user->setPassword($password);
        $user->save();

        // Redirect to login page
        $this->di->get("response")->redirect($this->di->get("url")->create("user/login"));
    }
}
