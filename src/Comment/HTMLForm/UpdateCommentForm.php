<?php

namespace Almrooth\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Almrooth\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class UpdateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $comment = $this->getItemDetails($id);
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
                    "value" => $comment->id,
                ],
                "content" => [
                    "type"          => "textarea",
                    "label"         => "Kommentar",
                    "validation"    => ["not_empty"],
                    "value"         => $comment->content,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera kommentar",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "btn"
                ],
            ]
        );
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Comment true if okey, false if something went wrong.
     */
    public function getItemDetails($id)
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $id);
        return $comment;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $this->form->value("id"));
        $comment->content   = $this->form->value("content");
        $comment->save();

        // Redirect to profile page
        $this->di->get("response")->redirect("comment");
    }
}
