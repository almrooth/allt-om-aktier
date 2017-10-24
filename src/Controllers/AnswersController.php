<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Comment\HTMLForm\AddCommentForm;
use \App\Answer\HTMLForm\UpdateAnswerForm;
use \App\Answer\Answer;
use \App\Comment\Comment;

/**
 * A controller class.
 *
 * @SuppressWarnings("camelcase")
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


    public function getPostUpdate($id)
    {
        $title      = "Updatera svar";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user_id    = $this->di->get("session")->get("user_id");
        $user_role = $this->di->get("session")->get("user_role");

        $answer   = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->find("id", $id);

        if (!($user_id == $answer->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }

        $form       = new UpdateAnswerForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML()
        ];

        $view->add("answers/update", $data);
        
        $pageRender->renderPage(["title" => $title]);
    }


    public function getDelete($id)
    {
        $user_id = $this->di->get("session")->get("user_id");
        $user_role = $this->di->get("session")->get("user_role");

        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->find("id", $id);

        if (!($user_id == $answer->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }
        $answer->delete();

        // Delete associated comments
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->deleteWhere("answer_id = ?", $id);

        $this->di->get("response")->redirect("questions/" . $answer->question_id);
    }


    public function getAccept($id)
    {
        $user_id = $this->di->get("session")->get("user_id");
        $user_role = $this->di->get("session")->get("user_role");

        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->find("id", $id);

        if (!($user_id == $answer->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }

        $answer->accept($id);

        $this->di->get("response")->redirect("questions/" . $answer->question_id);
    }
}
