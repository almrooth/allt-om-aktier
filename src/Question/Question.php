<?php

namespace App\Question;

use \Anax\Database\ActiveRecordModel;
use \Anax\TextFilter\TextFilter;
use \App\User\User;
use \App\Tag\Tag;
use \App\Tag\TagQuestion;
use \App\Answer\Answer;
use \App\Comment\Comment;
use \App\Vote\Vote;

/**
 * A database driven model.
 *
 * @SuppressWarnings("camelcase")
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_questions";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $user_id;
    public $title;
    public $content;
    public $created;
    public $updated;
    public $deleted;


    /**
     * Get all questions
     *
     * @return array of object, questions
     */
    public function getAll()
    {
        $questions = $this->findall();

        $questions = array_map(function ($question) {
            $question->content  = $this->parseContent($question->content);
            $question->user     = $this->user($question->user_id);
            $question->tags     = $this->tags($question->id);
            $question->answers  = $this->answers($question->id);
            $question->comments = $this->comments($question->id);
            $question->votes    = $this->votes($question->id);
            return $question;
        }, $questions);

        return $questions;
    }


    /**
     * Get a question by id
     *
     * @param integer $id the id of question to get
     * @return object the requested question
     */
    public function get($id)
    {
        $question           = $this->find("id", $id);
        $question->content  = $this->parseContent($question->content);
        $question->user     = $this->user($question->user_id);
        $question->tags     = $this->tags($question->id);
        $question->answers  = $this->answers($question->id);
        $question->comments = $this->comments($question->id);
        $question->votes    = $this->votes($question->id);
        return $question;
    }


    /**
     * Get a question by id sorted
     *
     * @param integer $id the id of question to get
     * @param string column to sort by
     * @return object the requested question
     */
    public function getSorted($id, $sortBy)
    {
        $question           = $this->find("id", $id);
        $question->content  = $this->parseContent($question->content);
        $question->user     = $this->user($question->user_id);
        $question->tags     = $this->tags($question->id);
        $question->answers  = $this->answers($id, $sortBy);
        $question->comments = $this->comments($question->id);
        $question->votes    = $this->votes($question->id);
        return $question;
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
     * Get all tags of question
     *
     * @param integer $id of question
     * @return array of object tag
     */
    public function tags($id)
    {
        $tags = [];

        $pivot = new TagQuestion();
        $pivot->setDb($this->db);
        if ($pivot->find("question_id", $id)) {
            $pivots = $pivot->findAllWhere("question_id = ?", $id);

            foreach ($pivots as $pivot) {
                $tag = new Tag();
                $tag->setDb($this->db);
                $tags[] = $tag->find("id", $pivot->tag_id);
            }
        }
        
        return $tags;
    }


    /**
     * Return all answers of question
     *
     * @param int $id of question
     * @return array of object answer
     */
    public function answers($id, $sortBy = "created")
    {
        $answer = new Answer();
        $answer->setDb($this->db);
        $answers = $answer->getAllByQ($id, $sortBy);

        return $answers;
    }


    /**
     * Return all comments of question
     *
     * @param int $id of question
     * @return array of object comment
     */
    public function comments($id)
    {
        $comment = new Comment();
        $comment->setDb($this->db);
        $comments = $comment->getAllByQ($id);

        return $comments;
    }


    /**
     * Return votes of question
     *
     * @param int $id of question
     * @return int of votes
     */
    public function votes($id)
    {
        $vote = new Vote();
        $vote->setDb($this->db);
        $votes = $vote->getVotes("question", $id);
        
        return ($votes == null) ? 0 : $votes;
    }
}
