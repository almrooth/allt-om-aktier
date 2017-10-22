<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Question\Question;

/**
 * A controller for the base pages.
 */
class BaseController implements InjectionAwareInterface
{
    use InjectionAwareTrait;


    // The index page
    public function getIndex()
    {
        $title      = "Start";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $db = $this->di->get("db");

        // Latest questions
        $questions = $db->connect()
                        ->select()
                        ->from("aoa_questions")
                        ->orderBy("created desc")
                        ->limit(5)
                        ->execute()
                        ->fetchAll();

        // Most popular tags
        $tags = $db->connect()
                   ->select("count(*) as nr, tag, tag_id")
                   ->from("aoa_tags_questions")
                   ->join("aoa_tags", "aoa_tags_questions.tag_id = aoa_tags.id")
                   ->groupBy("tag_id")
                   ->orderBY("nr desc")
                   ->limit(5)
                   ->execute()
                   ->fetchAll();

        // Mos active users
        $sql = "SELECT u.id, u.username, count(temp.user_id) AS activity FROM aoa_users AS u
        INNER JOIN (
            SELECT user_id FROM aoa_questions
            UNION ALL
            SELECT user_id FROM aoa_answers
            UNION ALL
            SELECT user_id FROM aoa_comments
        ) AS temp ON u.id = temp.user_id
        GROUP BY u.id
        ORDER BY activity DESC
        LIMIT 5;";

        $users = $db->connect()
                    ->execute($sql)
                    ->fetchAll();

        $data = [
            "questions" => $questions,
            "tags"      => $tags,
            "users"     => $users
        ];

        $view->add("base/index", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    // The about page
    public function getAbout()
    {
        $this->di->get("view")->add("base/about", []);
        $this->di->get("pageRender")->renderPage(["title" => "Om sidan"]);
    }
}
