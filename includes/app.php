<?php

    require __DIR__ . "/../vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/config");
    $dotenv->safeLoad();
    require "functions.php";
    require "config/database.php";
    

    // Connect to the database

    $db = connectDB();
    $db->set_charset('utf8');
    
    use Model\ActiveRecord;

    ActiveRecord::setDB($db);