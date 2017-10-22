<?php

namespace App\Answer\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\User\User;
use \App\Answer\Answer;

/**
 * Example of FormModel implementation.
 */
class AddAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "use_fieldset" => false,
            ],
            [
                "question" => [
                    "type"          => "hidden",
                    "value"         => $id
                ],

                "content" => [
                    "type"          => "textarea",
                    "label"         => "Svar",
                    "validation"    => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Spara svar",
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
        if (!$this->di->get("session")->has("username")) {
            $url = $this->di->get("url")->create("questions/" . $this->form->value("question"));
            $this->di->get("response")->redirect($url);
        }

        // Create new answer
        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->question_id    = $this->form->value("question");
        $answer->user_id        = $this->di->get("session")->get("user_id");
        $answer->content        = $this->form->value("content");
        $answer->created        = date("Y-m-d H:i:s");
        $answer->save();

        // Redirect to answers page
        $url = $this->di->get("url")->create("questions/" . $this->form->value("question"));
        $this->di->get("response")->redirect($url);
    }
}
