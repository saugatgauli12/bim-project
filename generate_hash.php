<?php
$password = 'newpassword123'; // your chosen new password
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>
