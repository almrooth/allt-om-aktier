<?php

namespace App\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\User\User;

/**
 * Example of FormModel implementation.
 */
class LoginForm extends FormModel
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

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
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

        // Connect to databse and se if user exists and if so compare password
        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->verifyPassword($username, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        // Get the user
        $user->find("username", $username);

        // Check if user is deleted
        if (isset($user->deleted)) {
            $this->form->rememberValues();
            $this->form->addOutput("Användaren är inaktiverad. Kontakta administratör.");
            return false;
        }

        // Save user to session
        $this->di->get("session")->set("user_id", $user->id);
        $this->di->get("session")->set("username", $user->username);
        $this->di->get("session")->set("user_role", $user->role);

        // Redirect to profile page
        $this->di->get("response")->redirect($this->di->get("url")->create(""));
    }
}
