<?php

namespace App\Controllers;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

use \App\Question\Question;
use \App\Answer\Answer;
use \App\Comment\Comment;
use \App\Vote\Vote;

/**
 * A controller class.
 *
 * @SuppressWarnings("camelcase")
 * @SuppressWarnings("cyclomaticComplexity")
 */
class VotesController implements
    InjectionAwareInterface
{
    use InjectionAwareTrait;

    
    public function getVoteUp($type, $id)
    {
        $user_id = $this->di->get("session")->get("user_id");

        $vote = new Vote();
        $vote->setDb($this->di->get("db"));

        $vote->user_id = $user_id;
        if ($type == "question") {
            $vote->findWhere("question_id = ? AND user_id =?", [$id, $user_id]);

            if ($vote->id == null) {
                $vote->question_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score < 1) {
                $vote->score += 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $id);
        } elseif ($type == "answer") {
            $vote->findWhere("answer_id = ? AND user_id =?", [$id, $user_id]);
            $answer = new Answer();
            $answer->setDb($this->di->get("db"));
            $answer->find("id", $id);

            if ($vote->id == null) {
                $vote->answer_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score < 1) {
                $vote->score += 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $answer->question_id);
        } elseif ($type == "comment") {
            $vote->findWhere("comment_id = ? AND user_id =?", [$id, $user_id]);
            $comment = new Comment();
            $comment->setDb($this->di->get("db"));
            $comment->find("id", $id);

            if ($vote->id == null) {
                $vote->comment_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score < 1) {
                $vote->score += 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $comment->question_id . "/comments");
        }
    }


    public function getVoteDown($type, $id)
    {
        $user_id = $this->di->get("session")->get("user_id");

        $vote = new Vote();
        $vote->setDb($this->di->get("db"));

        $vote->user_id = $user_id;
        if ($type == "question") {
            $vote->findWhere("question_id = ? AND user_id =?", [$id, $user_id]);

            if ($vote->id == null) {
                $vote->question_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score > -1) {
                $vote->score -= 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $id);
        } elseif ($type == "answer") {
            $vote->findWhere("answer_id = ? AND user_id =?", [$id, $user_id]);
            $answer = new Answer();
            $answer->setDb($this->di->get("db"));
            $answer->find("id", $id);

            if ($vote->id == null) {
                $vote->answer_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score > -1) {
                $vote->score -= 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $answer->question_id);
        } elseif ($type == "comment") {
            $vote->findWhere("comment_id = ? AND user_id =?", [$id, $user_id]);
            $comment = new Comment();
            $comment->setDb($this->di->get("db"));
            $comment->find("id", $id);

            if ($vote->id == null) {
                $vote->comment_id = $id;
                $vote->user_id = $user_id;
                $vote->score = 0;
            }
            if ($vote->score > -1) {
                $vote->score -= 1;
            }
            $vote->save();
            $this->di->get("response")->redirect("questions/" . $comment->question_id . "/comments");
        }
    }
}
