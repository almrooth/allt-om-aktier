<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "All questions",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["questionsController", "getAll"],
        ],
        [
            "info" => "New question",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["questionsController", "getPostCreate"],
        ],
        [
            "info" => "Comment on a question",
            "requestMethod" => "get|post",
            "path" => "{id:digit}/comments",
            "callable" => ["questionsController", "getPostComment"],
        ],
        [
            "info" => "Update a question",
            "requestMethod" => "get|post",
            "path" => "{id:digit}/update",
            "callable" => ["questionsController", "getPostUpdate"],
        ],
        [
            "info" => "Delete a question",
            "requestMethod" => "get",
            "path" => "{id:digit}/delete",
            "callable" => ["questionsController", "getDelete"],
        ],
        [
            "info" => "Show a question and its answers",
            "requestMethod" => "get|post",
            "path" => "{id:digit}",
            "callable" => ["questionsController", "getPostRead"],
        ],
    ]
];
