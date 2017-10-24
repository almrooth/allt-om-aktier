<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Vote up",
            "requestMethod" => "get",
            "path" => "{type}/{id:digit}/up",
            "callable" => ["votesController", "getVoteUp"],
        ],
        [
            "info" => "Vote down",
            "requestMethod" => "get",
            "path" => "{type}/{id:digit}/down",
            "callable" => ["votesController", "getVoteDown"],
        ],
    ]
];
