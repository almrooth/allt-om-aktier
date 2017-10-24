<?php

namespace App\Answer;

use \Anax\Database\ActiveRecordModel;
use \Anax\TextFilter\TextFilter;
use \App\User\User;
use \App\Comment\Comment;
use \App\Question\Question;
use \App\Vote\Vote;

/**
 * A database driven model.
 *
 * @SuppressWarnings("camelcase")
 * @SuppressWarnings("shortVariable")
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
    public $accepted;
    public $created;
    public $updated;
    public $deleted;


    /**
     * Get all answers by question id
     *
     * @return array of object, answers
     */
    public function getAllByQ($id, $sortBy)
    {
        // $answers = $this->findallWhere("question_id = ?", $id);
        $answers = $this->db->connect()
                            ->select()
                            ->from($this->tableName)
                            ->where("question_id = ?")
                            ->orderBy("created DESC")
                            ->execute([$id])
                            ->fetchAllClass(get_class($this));

        $answers = array_map(function ($answer) {
            $answer->content  = $this->parseContent($answer->content);
            $answer->user     = $this->user($answer->user_id);
            $answer->comments = $this->comments($answer->id);
            $answer->votes    = $this->votes($answer->id);
            return $answer;
        }, $answers);

        if ($sortBy == "votes") {
            usort($answers, function ($a, $b) {
                if ($a->votes == $b->votes) {
                    return 0;
                } elseif ($a->votes > $b->votes) {
                    return -1;
                } else {
                    return 1;
                }
            });
        }

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
        $answer->votes    = $this->votes($answer->id);

        return $answer;
    }


    public function accept($id)
    {
        $answer     = $this->find("id", $id);

        if ($answer->accepted) {
            $this->db->connect()
                     ->update($this->tableName, ["accepted"])
                     ->where("id = ?")
                     ->execute([false, $id]);
        } else {
            $this->db->connect()
                     ->update($this->tableName, ["accepted"])
                     ->where("id = ?")
                     ->execute([true, $id]);
        }
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


    /**
     * Return votes of answer
     *
     * @param int $id of answer
     * @return int of votes
     */
    public function votes($id)
    {
        $vote = new Vote();
        $vote->setDb($this->db);
        $votes = $vote->getVotes("answer", $id);

        return ($votes == null) ? 0 : $votes;
    }
}
