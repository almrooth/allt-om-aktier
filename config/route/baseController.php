<?php

return [
    "routes" => [
        [
            "info" => "Index page",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["baseController", "getIndex"],
        ],
        [
            "info" => "About page",
            "requestMethod" => "get",
            "path" => "about",
            "callable" => ["baseController", "getAbout"],
        ],
    ]
];
