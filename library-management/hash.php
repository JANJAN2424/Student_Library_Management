<?php
$plain_text = "admin";

// Hash the password
$hashed_password = password_hash($plain_text, PASSWORD_DEFAULT);

// Output the hashed password
echo "Plain Text: $plain_text<br>";
echo "Hashed Password: $hashed_password";
