<?php

namespace App\User;

use \Anax\Database\ActiveRecordModel;
use \App\Question\Question;
use \App\Answer\Answer;

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
}
