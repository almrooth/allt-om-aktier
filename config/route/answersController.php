<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Comment on an answer",
            "requestMethod" => "get|post",
            "path" => "{id:digit}/comments",
            "callable" => ["answersController", "getPostComment"],
        ],
        [
            "info" => "Update an answer",
            "requestMethod" => "get|post",
            "path" => "{id:digit}/update",
            "callable" => ["answersController", "getPostUpdate"],
        ],
        [
            "info" => "Delete an answer",
            "requestMethod" => "get",
            "path" => "{id:digit}/delete",
            "callable" => ["answersController", "getDelete"],
        ],
        [
            "info" => "Delete an answer",
            "requestMethod" => "get",
            "path" => "{id:digit}/accept",
            "callable" => ["answersController", "getAccept"],
        ],
    ]
];
