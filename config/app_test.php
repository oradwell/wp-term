<?php

return array(
    'hostname' => 'http://www.ockwebs.com',
    'permalink_structure' => '/%year%/%monthnum%/%postname%/',
    'post_src' => 'post_src_file',
    'post_src_file' => array(
        'type' => 'file',
        'path' => 'posts.csv',
    ),
    'post_src_db' => array(
        'type' => 'db',
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'wordpress',
        'username' => 'wpterm',
        'password' => 'tas3RE',
    ),
);
