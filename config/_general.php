<?php

return [

    // load only google analytics if it is in non-local environment
    "load_ga" => (env("APP_ENV") == "local") ? false : true,

    // for dummy accts
    "activate_dummy"    => env("ACTIVATE_DUMMY", false),
    "no_of_dummy_accts" => env("NO_OF_DUMMY_ACCTS", 5)
];
