<?php

use \Anax\Route\Router;

/**
 * Configuration file for routes.
 */
return [
    //"mode" => Router::DEVELOPMENT, // default, verbose execeptions
    //"mode" => Router::PRODUCTION,  // exceptions turn into 500

    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // To read flat file content in Markdown from content/
            "mount" => null,
            "file" => __DIR__ . "/route/flat-file-content.php",
        ],
        [
            // The base pages for the site
            "mount" => null,
            "file" => __DIR__ . "/route/baseController.php",
        ],
        [
            // User pages
            "mount" => "user",
            "file" => __DIR__ . "/route/userController.php",
        ],
        [
            // Questions pages
            "mount" => "questions",
            "file" => __DIR__ . "/route/questionsController.php",
        ],
        [
            // Tags pages
            "mount" => "tags",
            "file" => __DIR__ . "/route/tagsController.php",
        ],
        [
            // Answers pages
            "mount" => "answers",
            "file" => __DIR__ . "/route/answersController.php",
        ],
        [
            // Answers pages
            "mount" => "admin",
            "file" => __DIR__ . "/route/adminController.php",
        ],
        [
            // Keep this last since its a catch all
            "mount" => null,
            "sort" => 999,
            "file" => __DIR__ . "/route/404.php",
        ],
    ],

];
