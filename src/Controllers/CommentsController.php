<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Comment\HTMLForm\UpdateCommentForm;
use \App\Comment\Comment;

/**
 * A controller class.
 *
 * @SuppressWarnings("camelcase")
 */
class CommentsController implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;


    public function getPostUpdate($id)
    {
        $title      = "Updatera svar";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user_id    = $this->di->get("session")->get("user_id");
        $user_role    = $this->di->get("session")->get("user_role");

        $comment   = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $id);

        if (!($user_id == $comment->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }

        $form       = new UpdateCommentForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML()
        ];

        $view->add("comments/update", $data);
        
        $pageRender->renderPage(["title" => $title]);
    }


    public function getDelete($id)
    {
        $user_id        = $this->di->get("session")->get("user_id");
        $user_role      = $this->di->get("session")->get("user_role");

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $id);

        if (!($user_id == $comment->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }
        $comment->delete();

        $this->di->get("response")->redirect("questions");
    }
}
