<?php

namespace App\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\User\User;

/**
 * Example of FormModel implementation.
 */
class AdminUpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "use_fieldset" => false,
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "label" => "Användarnamn",
                    "readonly" => true,
                    "value" => $user->username,
                ],

                "role" => [
                    "type"        => "select",
                    "label"       => "Användartyp",
                    "options"     => [
                        "admin"   => "admin",
                        "user"    => "user",
                    ],
                    "value"    => $user->role,
                ],

                "email" => [
                    "type"          => "text",
                    "label"         => "Epost",
                    "validation"    => ["not_empty"],
                    "value"         => $user->email,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera profil",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "btn btn-green"
                ],
            ]
        );
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return User true if okey, false if something went wrong.
     */
    public function getItemDetails($id)
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        return $user;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $this->form->value("id"));
        $user->role     = $this->form->value("role");
        $user->email    = $this->form->value("email");
        $user->save();

        // Redirect to profile page
        $this->di->get("response")->redirect("user/profile/" . $user->id);
    }
}
