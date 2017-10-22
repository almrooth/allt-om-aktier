<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Tag\Tag;
use \App\Question\Question;

/**
 * A controller class.
 */
class TagsController implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;

    
    public function getAll()
    {
        $title          = "Alla taggar";
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $tag            = new Tag();
        $tag->setDb($this->di->get("db"));

        $data = [
            "tags" => $tag->getAll()
        ];

        $view->add("tags/all", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function get($id)
    {
        $view           = $this->di->get("view");
        $pageRender     = $this->di->get("pageRender");
        $tag            = new Tag();
        $tag->setDb($this->di->get("db"));

        $question      = new Question();
        $question->setDb($this->di->get("db"));

        $data = [
            "tag" => $tag->get($id),
            "questions" => $tag->questions($id)
        ];

        $title = $data["tag"]->tag;
        
        $view->add("questions/by-tag", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
