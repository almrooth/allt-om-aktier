<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Access control, only allow admins",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["adminController", "checkAdmin"],
        ],
        [
            "info" => "Delete user",
            "requestMethod" => "get",
            "path" => "users/{id:digit}/delete",
            "callable" => ["adminController", "getDeleteUser"],
        ],
        [
            "info" => "Restore deleted user",
            "requestMethod" => "get",
            "path" => "users/{id:digit}/restore",
            "callable" => ["adminController", "getRestoreUser"],
        ],
        [
            "info" => "Edit user",
            "requestMethod" => "get|post",
            "path" => "users/{id:digit}",
            "callable" => ["adminController", "getPostUpdateUser"],
        ],
        [
            "info" => "Show all users",
            "requestMethod" => "get",
            "path" => "users",
            "callable" => ["adminController", "getUsers"],
        ],
        [
            "info" => "Edit question",
            "requestMethod" => "get",
            "path" => "questions/{id:digit}",
            "callable" => ["adminController", "getPostUpdateQuestion"],
        ],
        [
            "info" => "Show all questions",
            "requestMethod" => "get",
            "path" => "questions",
            "callable" => ["adminController", "getQuestions"],
        ],
        [
            "info" => "Show all answers",
            "requestMethod" => "get",
            "path" => "answers",
            "callable" => ["adminController", "getAnswers"],
        ],
        [
            "info" => "Show all comments",
            "requestMethod" => "get",
            "path" => "comments",
            "callable" => ["adminController", "getComments"],
        ],
    ]
];
