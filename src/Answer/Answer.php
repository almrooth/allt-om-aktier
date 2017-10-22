<?php

namespace App\Answer;

use \Anax\Database\ActiveRecordModel;
use \Anax\TextFilter\TextFilter;
use \App\User\User;
use \App\Comment\Comment;
use \App\Question\Question;

/**
 * A database driven model.
 *
 * @SuppressWarnings("camelcase")
 */
class Answer extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_answers";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $question_id;
    public $user_id;
    public $content;
    public $created;
    public $updated;
    public $deleted;


    /**
     * Get all answers by question id
     *
     * @return array of object, answers
     */
    public function getAllByQ($id)
    {
        $answers = $this->findallWhere("question_id = ?", $id);

        $answers = array_map(function ($answer) {
            $answer->content  = $this->parseContent($answer->content);
            $answer->user     = $this->user($answer->user_id);
            $answer->comments = $this->comments($answer->id);
            return $answer;
        }, $answers);

        return $answers;
    }


    /**
     * Get a answer by id
     *
     * @param integer $id the id of answer to get
     * @return object the requested answer
     */
    public function get($id)
    {
        $answer           = $this->find("id", $id);
        $answer->content  = $this->parseContent($answer->content);
        $answer->user     = $this->user($answer->user_id);
        $answer->comments = $this->comments($answer->id);
        $answer->question = $this->question($answer->question_id);

        return $answer;
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


    public function question($id)
    {
        $question = new Question();
        $question->setDb($this->db);
        return $question->find("id", $id);
    }


    /**
     * Get user of comment
     *
     * @param integer $id of user
     * @return object user
     */
    public function user($id)
    {
        $user = new User();
        $user->setDb($this->db);
        return $user->find("id", $id);
    }


    /**
     * Return all comments of asnwer
     *
     * @param int $id of answer
     * @return array of object comment
     */
    public function comments($id)
    {
        $comment = new Comment();
        $comment->setDb($this->db);
        $comments = $comment->getAllByA($id);

        return $comments;
    }
}
