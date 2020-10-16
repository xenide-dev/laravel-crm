<?php

return [

    // privilege
    // 'name' | string => the name of the url
    // 'access' | array => the permissions
    // 'text' | optional | string => the display text

    "urls" => [
        [
            "name" => "directory",
            "access" => [ "view" ],
            "text" => "Blacklisted"
        ],
        [
            "name" => "accounts",
            "access" => [ "view", "add", "update", "delete" ]
        ],
        [
            "name" => "privilege",
            "access" => [ "view", "update" ]
        ],
    ],


];
