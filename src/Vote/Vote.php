<?php

namespace App\Vote;

use \Anax\Database\ActiveRecordModel;
use \App\Question\Question;
use \App\Answer\Answer;
use \App\Comment\Comment;

/**
 * A database driven model.
 *
 * @SuppressWarnings("camelcase")
 */
class Vote extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_votes";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $user_id;
    public $question_id;
    public $answer_id;
    public $comment_id;


    public function getVotes($type, $id)
    {
        $res = $this->db->connect()
                        ->select("sum(score) AS score")
                        ->from($this->tableName)
                        ->where($type . "_id = ?")
                        ->execute([$id])
                        ->fetch();
        
                        
        return $res->score;
    }
}
