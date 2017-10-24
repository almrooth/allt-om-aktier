<?php

namespace App\Comment;

use \Anax\Database\ActiveRecordModel;
use \Anax\TextFilter\TextFilter;
use \App\User\User;
use \App\Vote\Vote;

/**
 * A database driven model.
 * @SuppressWarnings("camelcase")
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_comments";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $user_id;
    public $content;
    public $created;
    public $updated;
    public $deleted;


    public function getAll()
    {
        $comments = $this->findAll();

        return array_map(function ($comment) {
            $user = $this->user($comment->user_id);
            $comment->gravatar = $this->gravatar($user->email);
            $comment->username = $user->username;
            $comment->votes    = $this->votes($comment->id);
            return $comment;
        }, $comments);
    }


    public function get($id)
    {
        $comment            = $this->find("id", $id);
        $comment->content   = $this->parseContent($comment->content);
        $comment->user      = $this->user($comment->user_id);
        $comment->votes    = $this->votes($comment->id);

        return $comment;
    }


    public function getAllByQ($id)
    {
        $comments = $this->findAllWhere("question_id = ?", $id);

        $comments = array_map(function ($comment) {
            $comment->content   = $this->parseContent($comment->content);
            $comment->user      = $this->user($comment->user_id);
            $comment->votes    = $this->votes($comment->id);
            return $comment;
        }, $comments);

        return $comments;
    }


    public function getAllByA($id)
    {
        $comments = $this->findAllWhere("answer_id = ?", $id);

        $comments = array_map(function ($comment) {
            $comment->content   = $this->parseContent($comment->content);
            $comment->user      = $this->user($comment->user_id);
            $comment->votes    = $this->votes($comment->id);
            return $comment;
        }, $comments);

        return $comments;
    }


    /**
     * Parse content for markdown
     *
     * @param string $content
     * @return string
     */
    public function parseContent($content)
    {
        $textfilter = new TextFilter();
        return $textfilter->parse($content, ["markdown"])->text;
    }


    public function user($id)
    {
        $user = new User();
        $user->setDb($this->db);
        return $user->find("id", $id);
    }


    /**
     * Return votes of comment
     *
     * @param int $id of comment
     * @return int of votes
     */
    public function votes($id)
    {
        $vote = new Vote();
        $vote->setDb($this->db);
        $votes = $vote->getVotes("comment", $id);

        return ($votes == null) ? 0 : $votes;
    }
}
