<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Update a comment",
            "requestMethod" => "get|post",
            "path" => "{id:digit}/update",
            "callable" => ["commentsController", "getPostUpdate"],
        ],
        [
            "info" => "Delete a comment",
            "requestMethod" => "get",
            "path" => "{id:digit}/delete",
            "callable" => ["commentsController", "getDelete"],
        ],
    ]
];
