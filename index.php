<?php
require 'jwt.php';

$payload = ['name' => 'Rajeesh', 'department' => 'IT'];
const KEY = 'testkey123';

echo TokenJwt::Sign($payload,KEY,60);

$token = '';

// print_r(TokenJwt::verify($token,KEY));