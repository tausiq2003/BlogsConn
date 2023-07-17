<?php
$password = "blogsconn@2023";
$hashedPassword = "$2y$10$2p5cOyS8aKd.8VrBabvbq.Y5apSyYf.o5CdFUh566jwK4MluIgX4";
echo $password;
echo $hashedPassword;

if (password_verify($password, $hashedPassword)) {
    echo "Password is correct";
} else {
    echo "Password is incorrect";
}
?>