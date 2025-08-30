<?php
$password = '123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


echo "<br>";
echo "رمز عبور هش شده برای '123': ";

echo "<br>";

echo $hashed_password;
?>