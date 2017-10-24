<?php

namespace App\Answer\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\Answer\Answer;

/**
 * Example of FormModel implementation.
 */
class UpdateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $answer = $this->getItemDetails($id);
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
                    "value" => $answer->id,
                ],
                "content" => [
                    "type"          => "textarea",
                    "label"         => "Kommentar",
                    "validation"    => ["not_empty"],
                    "value"         => $answer->content,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera kommentar",
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
     * @return Question true if okey, false if something went wrong.
     */
    public function getItemDetails($id)
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->find("id", $id);
        return $answer;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->find("id", $this->form->value("id"));
        $answer->content   = $this->form->value("content");
        $answer->save();

        // Redirect to profile page
        $this->di->get("response")->redirect("questions/" . $answer->question_id);
    }
}
