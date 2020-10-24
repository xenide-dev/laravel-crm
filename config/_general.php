<?php

return [

    // load only google analytics if it is in non-local environment
    "load_ga" => (env("APP_ENV") == "local") ? false : true
];
