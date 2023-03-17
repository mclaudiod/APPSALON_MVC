<?php

    function connectDB() : mysqli {
        $db = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_DB"]);

        if(!$db) {
            echo "It wasn't possible to connect to the Database";
            echo "Depuration errno: " . mysqli_connect_errno();
            echo "Depuration error: " . mysqli_connect_error();
            exit;
        };

        return $db;
    };