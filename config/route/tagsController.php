<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "All tags",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["tagsController", "getAll"],
        ],
        [
            "info" => "Show questions with a certain tag",
            "requestMethod" => "get",
            "path" => "{id:digit}",
            "callable" => ["tagsController", "get"],
        ],
    ]
];
