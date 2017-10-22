<?php

namespace App\Question\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \App\Question\Question;
use \App\User\User;
use \App\Tag\Tag;
use \App\Tag\TagQuestion;

/**
 * Example of FormModel implementation.
 */
class AddQuestionForm extends FormModel
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
                "title" => [
                    "type"          => "text",
                    "label"         => "Titel",
                    "validation"    => ["not_empty"],
                ],

                "content" => [
                    "type"          => "textarea",
                    "label"         => "Fråga",
                    "validation"    => ["not_empty"],
                ],

                "tags" => [
                    "type"          => "text",
                    "label"         => "Taggar"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Spara fråga",
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
            $this->di->get("response")->redirect($this->di->get("url")->create("questions"));
        }

        // Create new question
        $question = new Question();
        $question->setDb($this->di->get("db"));
        $question->user_id  = $this->di->get("session")->get("user_id");
        $question->title    = $this->form->value("title");
        $question->content  = $this->form->value("content");
        $question->created  = date("Y-m-d H:i:s");
        $question->save();

        // Tags
        $tags = $this->form->value("tags");
        if (!empty(trim($tags))) {
            $tags = preg_split("/[\s,]+/", $tags);
        }

        if (!empty($tags)) {
            foreach ($tags as $newTag) {
                $newTag = strtolower($newTag);
                $tag = new Tag();
                $tag->setDb($this->di->get("db"));
                $tag->find("tag", $newTag);
    
                if ($tag->tag == null) {
                    $tag->tag = $newTag;
                    $tag->save();
                }
    
                $pivot = new TagQuestion();
                $pivot->setDb($this->di->get("db"));
                $pivot->tag_id = $tag->id;
                $pivot->question_id = $question->id;
                $pivot->save();
            }
        }

        // Redirect to questions page
        $this->di->get("response")->redirect($this->di->get("url")->create("questions"));
    }
}
