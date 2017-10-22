<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Comment\HTMLForm\AddCommentForm;
use \App\Answer\Answer;

/**
 * A controller class.
 */
class AnswersController implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;


    public function getPostComment($id)
    {
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $answer         = new Answer();
        $answer->setDb($this->di->get("db"));

        // Comment form
        $form           = new AddCommentForm($this->di, $id, "answer");

        $form->check();

        $data = [
            "answer"    => $answer->get($id),
            "form"      => $form->getHTML()
        ];

        $title = $data["answer"]->question->title;

        $view->add("answers/comments", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
