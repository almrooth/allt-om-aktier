<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \App\User\User;
use \App\Question\Question;

use \App\User\HTMLForm\UpdateUserForm;

/**
 * A controller for the admin pages.
 */
class AdminController implements InjectionAwareInterface
{
    use InjectionAwareTrait;


    public function checkAdmin()
    {
        if ($this->di->get("session")->get("user_role") != "admin") {
            $this->di->get("response")->redirect("");
        }
    }


    // The users page
    public function getUsers()
    {
        $title      = "Användare";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $user->setDb($this->di->get("db"));

        $data = [
            "users" => $user->findAll()
        ];

        $view->add("admin/users", $data);
        
        $pageRender->renderPage(["title" => $title]);
    }


    /**
     * Handle with form user update
     *
     * @return void
     */
    public function getPostUpdateUser($id)
    {
        $title      = "Updatera profil";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UpdateUserForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML()
        ];

        $view->add("user/update", $data);
        
        $pageRender->renderPage(["title" => $title]);
    }


    public function getDeleteUser($id)
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        $user->deleted = date("Y-m-d H:i:s");
        $user->save();

        $this->di->get("response")->redirect("admin/users");
    }


    public function getRestoreUser($id)
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);
        $user->deleted = null;
        $user->save();

        $this->di->get("response")->redirect("admin/users");
    }


    // The questions page
    public function getQuestions()
    {
        $title      = "Frågor";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $question = new Question();
        $question->setDb($this->di->get("db"));

        $data = [
            "questions" => $question->getAll()
        ];

        $view->add("admin/questions", $data);
        
        $pageRender->renderPage(["title" => $title]);
    }
}
