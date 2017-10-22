<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "User profile page",
            "requestMethod" => "get",
            "path" => "profile/{id:digit}",
            "callable" => ["userController", "getProfile"],
        ],
        [
            "info" => "User register",
            "requestMethod" => "get|post",
            "path" => "register",
            "callable" => ["userController", "getPostRegister"],
        ],
        [
            "info" => "Update user profile",
            "requestMethod" => "get|post",
            "path" => "update",
            "callable" => ["userController", "getPostUpdate"],
        ],
        [
            "info" => "Login user",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Logout user",
            "requestMethod" => "get",
            "path" => "logout",
            "callable" => ["userController", "getLogout"],
        ],
        [
            "info" => "All users",
            "requestMethod" => "get",
            "path" => "all",
            "callable" => ["userController", "getAllUsers"],
        ],
    ]
];
