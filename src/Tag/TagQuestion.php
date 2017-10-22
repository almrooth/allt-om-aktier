<?php

namespace App\Tag;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 *
 * @SuppressWarnings("camelcase")
 */
class TagQuestion extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "aoa_tags_questions";

    protected $db;
    
    public function __construct($db = null)
    {
        $this->db = $db;
    }



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag_id;
    public $question_id;
}
