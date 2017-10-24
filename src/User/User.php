<?php

namespace App\User;

use \Anax\Database\ActiveRecordModel;
use \App\Question\Question;
use \App\Answer\Answer;
use \App\Comment\Comment;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_users";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $role;
    public $username;
    public $password;
    public $email;
    public $created;
    public $updated;
    public $deleted;


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }


    /**
     * Verify the username and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $username  username to check.
     * @param string $password the password to use.
     *
     * @return boolean true if username and password matches, else false.
     */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }

    public function gravatar()
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email)));
    }


    public function getAll()
    {
        $users = $this->findAllWhere("deleted IS NULL OR deleted = ?", "");
        return $users;
    }

    /**
     * Get user by id
     *
     * @param int $id od user
     * @return object $user
     */
    public function get($id)
    {
        $user                       = $this->find("id", $id);
        $user->questions            = $this->questions($id);
        $user->answeredQuestions    = $this->answeredQuestions($id);
        $user->score                = $this->score($id);
        return $user;
    }


    public function questions($id)
    {
        $question = new Question();
        $question->setDb($this->db);
        $questions = $question->findAllWhere("user_id = ?", $id);

        return $questions;
    }


    public function answeredQuestions($id)
    {
        return $this->db->connect()
                        ->select("DISTINCT aoa_questions.id, aoa_questions.title")
                        ->from("aoa_questions")
                        ->join("aoa_answers", "aoa_questions.id = aoa_answers.question_id")
                        ->where("aoa_answers.user_id = ?")
                        ->execute([$id])
                        ->fetchAll();
    }


    // Return the score of a user
    public function score($id)
    {
        // Questions
        $questions =   $this->db->connect()
                                ->select()
                                ->from("aoa_questions")
                                ->where("user_id = ?")
                                ->execute([$id])
                                ->fetchAll();
        
        $qScore = count($questions) * 5;

        foreach ($questions as $question) {
            $score = $this->db->connect()
                              ->select("sum(score) as score")
                              ->from("aoa_votes")
                              ->where("question_id = ?")
                              ->execute([$question->id])
                              ->fetch()->score;
            
            $qScore += $score;
        }

        // Answers
        $answers =     $this->db->connect()
                                ->select()
                                ->from("aoa_answers")
                                ->where("user_id = ?")
                                ->execute([$id])
                                ->fetchAll();

        $aScore = count($answers) * 10;

        foreach ($answers as $answer) {
            $score =   $this->db->connect()
                                ->select("sum(score) as score")
                                ->from("aoa_votes")
                                ->where("answer_id = ?")
                                ->execute([$answer->id])
                                ->fetch()->score;

            $aScore += $score;
        }

        // Comments
        $comments =    $this->db->connect()
                                ->select()
                                ->from("aoa_comments")
                                ->where("user_id = ?")
                                ->execute([$id])
                                ->fetchAll();

        $cScore = count($comments) * 5;

        foreach ($comments as $comment) {
            $score =   $this->db->connect()
                                ->select("sum(score) as score")
                                ->from("aoa_votes")
                                ->where("comment_id = ?")
                                ->execute([$comment->id])
                                ->fetch()->score;

            $cScore += $score;
        }
        
        return $qScore + $aScore + $cScore;
    }

    public function activity($id)
    {
        $activity = new \stdClass();

        $activity->questions = $this->db->connect()
                                        ->select("count(*) as count")
                                        ->from("aoa_questions")
                                        ->where("user_id = ?")
                                        ->execute([$id])
                                        ->fetch()->count;

        $activity->answers = $this->db->connect()
                                      ->select("count(*) as count")
                                      ->from("aoa_answers")
                                      ->where("user_id = ?")
                                      ->execute([$id])
                                      ->fetch()->count;

        $activity->comments =  $this->db->connect()
                                        ->select("count(*) as count")
                                        ->from("aoa_comments")
                                        ->where("user_id = ?")
                                        ->execute([$id])
                                        ->fetch()->count;

        $activity->votes = $this->db->connect()
                                    ->select("count(*) as count")
                                    ->from("aoa_votes")
                                    ->where("user_id = ?")
                                    ->execute([$id])
                                    ->fetch()->count;

        return $activity;
    }
}
