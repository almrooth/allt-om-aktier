<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Question\HTMLForm\AddQuestionForm;
use \App\Question\Question;
use \App\Answer\HTMLForm\AddAnswerForm;
use \App\Comment\HTMLForm\AddCommentForm;

/**
 * A controller class.
 */
class QuestionsController implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Get all questions
     *
     * @return void
     */
    public function getAll()
    {
        $title          = "Alla frågor";
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $question      = new Question();
        $question->setDb($this->di->get("db"));

        $data = [
            "questions" => $question->getAll()
        ];

        $view->add("questions/all", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostCreate()
    {
        // Check if user is logged in
        if (!$this->di->get("session")->has("username")) {
            $this->di->get("response")->redirect("");
        }

        $title      = "Ny fråga";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new AddQuestionForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("questions/create", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostRead($id)
    {
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $question       = new Question();
        $question->setDb($this->di->get("db"));

        // Answer form
        $form           = new AddAnswerForm($this->di, $id);

        $form->check();

        $data = [
            "question"  => $question->get($id),
            "form"      => $form->getHTML()
        ];

        $title = $data["question"]->title;

        $view->add("questions/read", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostComment($id)
    {
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $question       = new Question();
        $question->setDb($this->di->get("db"));

        // Comment form
        $form           = new AddCommentForm($this->di, $id, "question");

        $form->check();

        $data = [
            "question"  => $question->get($id),
            "form"      => $form->getHTML()
        ];

        $title = $data["question"]->title;

        $view->add("questions/comments", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
