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
    ]
];
