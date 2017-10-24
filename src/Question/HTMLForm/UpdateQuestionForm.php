<?php

namespace App\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\Question\Question;

/**
 * Example of FormModel implementation.
 */
class UpdateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $question = $this->getItemDetails($id);
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
                    "value" => $question->id,
                ],
                "title" => [
                    "type"          => "text",
                    "label"         => "Titel",
                    "validation"    => ["not_empty"],
                    "value"         => $question->title,
                ],
                "content" => [
                    "type"          => "textarea",
                    "label"         => "Kommentar",
                    "validation"    => ["not_empty"],
                    "value"         => $question->content,
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
        $question = new Question();
        $question->setDb($this->di->get("db"));
        $question->find("id", $id);
        return $question;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $question = new Question();
        $question->setDb($this->di->get("db"));
        $question->find("id", $this->form->value("id"));
        $question->title   = $this->form->value("title");
        $question->content   = $this->form->value("content");
        $question->save();

        // Redirect to profile page
        $this->di->get("response")->redirect("questions/" . $question->id);
    }
}
