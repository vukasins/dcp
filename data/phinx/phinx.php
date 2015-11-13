<?php

return array(
    "paths" => array(
        "migrations" => "migrations/"
    ),
    "environments" => array(
        "default_migration_table" => "migrations_log",
        "default_database" => "default",

        // all DB connections
        "default" => array(
            "adapter" => 'mysql',
            "host" => 'localhost',
            "name" => 'dcp',
            "user" => 'root', // set username
            "pass" => '', // and pass
            "port" => '3306'
        )
    )
);
