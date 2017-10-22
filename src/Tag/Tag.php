<?php

namespace App\Tag;

use \Anax\Database\ActiveRecordModel;
use \App\Tag\TagQuestion;
use \App\Question\Question;

/**
 * A database driven model.
 */
class Tag extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_tags";


    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag;


    /**
     * Get all tags
     *
     * @return array of object, tags
     */
    public function getAll()
    {
        $tags = $this->findall();

        $tags = array_map(function ($tag) {
            $tag->count    = $this->count($tag->id);
            return $tag;
        }, $tags);

        return $tags;
    }


    /**
     * Get a tag by id
     *
     * @param integer $id the id of tag to get
     * @return object the requested tag
     */
    public function get($id)
    {
        $tag = $this->find("id", $id);
        return $tag;
    }


    /**
     * Return count of questions for a tag
     *
     * @param integer  $id the tag to count
     * @return integer
     */
    public function count($id)
    {
        $pivot = new TagQuestion();
        $pivot->setDb($this->db);
        $pivots = $pivot->findAllWhere("tag_id = ?", $id);
        return count($pivots);
    }


    /**
     * Get all questions of tag
     *
     * @param integer $id of tag
     * @return array of object question
     */
    public function questions($id)
    {
        $questions = [];

        $pivot = new TagQuestion();
        $pivot->setDb($this->db);
        $pivots = $pivot->findAllWhere("tag_id = ?", $id);

        foreach ($pivots as $pivot) {
            $question = new Question();
            $question->setDb($this->db);
            $questions[] = $question->get($pivot->question_id);
        }

        return $questions;
    }
}
