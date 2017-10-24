<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Question\HTMLForm\AddQuestionForm;
use \App\Question\HTMLForm\UpdateQuestionForm;
use \App\Question\Question;
use \App\Answer\HTMLForm\AddAnswerForm;
use \App\Comment\HTMLForm\AddCommentForm;
use \App\Comment\Comment;
use \App\Answer\Answer;
use \App\Tag\Tag;
use \App\Tag\TagQuestion;

/**
 * A controller class.
 *
 * @SuppressWarnings("camelcase")
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

        $sortBy = $this->di->get("request")->getGet("sortBy");

        // Answer form
        $form           = new AddAnswerForm($this->di, $id);

        $form->check();

        $data = [
            "question"  => $question->getSorted($id, $sortBy),
            "form"      => $form->getHTML()
        ];

        $title = $data["question"]->title;

        $view->add("questions/read", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostUpdate($id)
    {
        $title      = "Updatera fråga";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user_id    = $this->di->get("session")->get("user_id");
        $user_role    = $this->di->get("session")->get("user_role");
        $question   = new Question();
        $question->setDb($this->di->get("db"));
        $question->find("id", $id);

        if (!($user_id == $question->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }

        $form       = new UpdateQuestionForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML()
        ];

        $view->add("questions/update", $data);
        
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


    public function getDelete($id)
    {
        $user_id = $this->di->get("session")->get("user_id");
        $user_role = $this->di->get("session")->get("user_role");

        $question = new Question();
        $question->setDb($this->di->get("db"));
        $question->find("id", $id);

        if (!($user_id == $question->user_id || $user_role == "admin")) {
            $this->di->get("response")->redirect("questions");
        }
        $question->delete();

        // Delete associated comments
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->deleteWhere("question_id = ?", $id);

        // Delete associated answers
        $answer = new Answer();
        $answer->setDb($this->di->get("db"));
        $answer->deleteWhere("question_id = ?", $id);

        // Delete tag if empty
        $pivot = new TagQuestion();
        $pivot->setDb($this->di->get("db"));
        $pivots = $pivot->findAllWhere("question_id = ?", $id);

        $tag = new Tag();
        $tag->setDb($this->di->get("db"));
        foreach ($pivots as $piv) {
            $db = $this->di->get("db");
            $nr = $db->connect()
                     ->select("count(*) AS nr")
                     ->from("aoa_tags_questions")
                     ->where("tag_id = ?")
                     ->execute([$piv->tag_id])
                     ->fetch();
            
            if ($nr->nr == 1) {
                $tag->find("id", $piv->tag_id);
                $tag->delete();
            }
        }

        $pivot->deleteWhere("question_id = ?", $id);

        $this->di->get("response")->redirect("questions");
    }
}
