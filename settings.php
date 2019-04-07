<?php

$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

\Cloudinary::config(array(
    "cloud_name" => getenv("cloud_name"),
    "api_key" => getenv("api_key"),
    "api_secret" => getenv("api_secret")
));
