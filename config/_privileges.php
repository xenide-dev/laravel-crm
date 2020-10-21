<?php

return [

    // privilege
    // 'name'   | required | string => the name of the url
    // 'access' | required | array  => the permissions
    // 'type'   | required | string => for whom? admin | user | all = make it sure that admin & user are the values you used in user column
    // 'text'   | optional | string => the display text

    "urls" => [
        [
            "name" => "directory",
            "access" => [ "view" ],
            "text" => "Blacklisted",
            "type" => "all"
        ],
        [
            "name" => "directory",
            "access" => [ "add" ],
            "text" => "Blacklisted (Add)",
            "type" => "admin"
        ],
        [
            "name" => "tickets",
            "access" => [ "view", "add" ],
            "type" => "all"
        ],
        [
            "name" => "accounts",
            "access" => [ "view", "add", "update", "delete" ],
            "type" => "admin"
        ],
        [
            "name" => "privilege",
            "access" => [ "view", "update" ],
            "type" => "admin"
        ],
    ],


];
