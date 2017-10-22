<?php

namespace App\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\User\User;
use \App\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class AddCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id, $for)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "use_fieldset" => false,
            ],
            [
                "parent" => [
                    "type"          => "hidden",
                    "value"         => $id
                ],
                
                "for" => [
                    "type"          => "hidden",
                    "value"         => $for
                ],

                "content" => [
                    "type"          => "textarea",
                    "label"         => "Kommentar",
                    "validation"    => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Spara kommentar",
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

        // Create new comment
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));

        if ($this->form->value("for") == "question") {
            $comment->question_id = $this->form->value("parent");
        } elseif ($this->form->value("for") == "answer") {
            $comment->answer_id = $this->form->value("parent");
        }

        $comment->user_id   = $this->di->get("session")->get("user_id");
        $comment->content   = $this->form->value("content");
        $comment->created   = date("Y-m-d H:i:s");
        $comment->save();

        // Redirect to profile page
        $this->di->get("response")->redirectSelf();
    }
}
