<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
// require 'phpmailer/src/Exception.php';
// require 'phpmailer/src/PHPMailer.php';
// require 'phpmailer/src/SMTP.php';

require 'config.php';

// establishing a connection to the database 
$conn = mysqli_connect($database['host'], $database['username'], $database['password'], $database['database']);

// Checking if the connection is established or not
if (!$conn) {
    echo "<h3>Not able to establish Database connection</h3>";
}

// fetching all the blogs from database
$sql = "SELECT * FROM blogsdata WHERE status = 1 ORDER BY id DESC";

$query = mysqli_query($conn, $sql);
// inserting the new blog into database
if (isset($_REQUEST['new_post'])) {

    $blog_image = $_FILES['blog__img'];

    $filename = $blog_image['name'];
    $filename_tmp = $blog_image['tmp_name'];

    $profile_ext = explode('.', $filename);
    $filecheck = strtolower(end($profile_ext));

    $file_ext_stored = array('jpeg', 'png', 'jpg');

    if (in_array($filecheck, $file_ext_stored)) {

        $destinationFile = "uploads/" . $filename;
        move_uploaded_file($filename_tmp, $destinationFile);
    } else {
        $destinationFile = null;
    }

    $title = $_REQUEST['title'];
    $content = $_REQUEST['editor1'];
    $category = $_REQUEST['blog__topic'];
    $userId = $_REQUEST['userId'];
    $sql_query = $conn->prepare("INSERT INTO blogsdata(title, content,  user_id, blog_image, category) VALUES (?, ?,  ?, ?, ?)");
    $sql_query->bind_param("ssiss", $title, $content, $_SESSION['uid'], $destinationFile, $category);
    $sql_query->execute();

    header("Location: index.php?info=added");
    exit();

 
   
}

if (isset($_REQUEST['id'])) {
    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);

    $sql = "SELECT * FROM blogsdata WHERE id = '$id' AND status = 1";
    $query = mysqli_query($conn, $sql);
}

if (isset($_REQUEST['update'])) {
    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
    $content = mysqli_real_escape_string($conn, $_REQUEST['editor1']);

    // using mysql prepared statement
    $stmt = $conn->prepare("UPDATE blogsdata SET title = ?, content = ?
        WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: index.php?info=updated");
    exit();
}

if (isset($_REQUEST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);

    $stmt = $conn->prepare("SELECT blog_image FROM blogsdata WHERE id = ? AND status = 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ans = $result->fetch_assoc();
    $filename = $ans['blog_image'];

    if (isset($filename)) {
        // deletes the image from /uploads as well
        unlink($filename);
    }

    $stmt = $conn->prepare("DELETE FROM blogsdata WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php?info=deleted");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $con_pwd = $_POST['confirmPassword'];
    

    // Use prepared statements to prevent SQL injection
    $query = "SELECT email FROM userdetails WHERE email = ? AND status = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    if ($num >= 1) {
        header("Location: register.php?info=present");
        exit();
    }

    if ($pwd === $con_pwd) {
        $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
        $bio = '';

        // Use prepared statements to prevent SQL injection
        $sql_query = "INSERT INTO userdetails (name, email, avatar, password, bio, date) VALUES (?, ?, 'avatar/avatar.png', ?, ?, current_timestamp())";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $bio);
        $stmt->execute();
        header("Location: login.php?info=registered");
        exit();
    } else {
        header("Location: register.php?info=error");
        exit();
    }
}


if (isset($_POST['profile__btn'])) {
    $bio = trim($_POST['profile__bio']);
    $profile_id = intval($_POST['profile__user_id']);

    if (empty($bio) || empty($profile_id)) {
        // Handle error here
        exit;
    }

    // Using Mysql prepared statement
    $sql = $conn->prepare("UPDATE userdetails SET bio = ? WHERE user_id = ?");
    $sql->bind_param("si", $bio, $profile_id);
    $sql->execute();

    if ($sql->affected_rows === 1) {
        header("Location: profile.php?uid=$profile_id");
        exit;
    } else {
        // Handle error here
        exit;
    }
}






if (isset($_POST['new_pass'])) {

    $pass_email = $_POST['pass_email'];

    $sql = $conn->prepare("SELECT user_id FROM userdetails WHERE email = ?");
    $sql->bind_param("s", $pass_email);
    $sql->execute();
    $res = $sql->get_result();
    $ans = $res->fetch_assoc();
    $userId = $ans['user_id'];

    if (empty($userId)) {
        header("Location: fpemail.php?info=invalid");
        exit;
    }

        
        
        $mail = new PHPMailer(true);
        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = 'user_email';
        $mail -> Password = 'user_pass';
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port = 465;
        $mail -> setFrom('user_email', 'BlogsConn');
        $mail -> addAddress($pass_email);
        $mail -> Subject = 'Password Reset - BlogsConn';
        $body    = '<div>
                            <h2>BlogIt - Password Reset</h2>
                        </div>' .
        '<p style = "font-size: 1.4rem"> To reset password, <a style = "text-decoration:none" href = "http://localhost/BlogsConn/passwordReset.php?id=' . $userId . '"> Click here </a></p>';
        $mail -> MsgHTML($body);
        $result = $mail -> Send();
        if(!$result){
            echo "Mailer Error: " . $mail -> ErrorInfo;
        }
        else{
             // Adding time interval
        $release = date("H:i:s");
        $endTime = strtotime("+15 minutes", strtotime($release));
        $expire = date('H:i:s', $endTime);
        $sql = $conn->prepare("INSERT INTO forgotpassword(user_id, release_time, expire_time) VALUES($userId, '$release', '$expire')");
        $sql->execute();

        // redirecting to the home page
        header("Location: fpemail.php?info=sent");
        echo 'Message has been sent';
        exit();
    }
}

// // password reset 

if (isset($_POST['pass_reset'])) {
    $pass = $_POST['password'];
    $con_pass = $_POST['confirmPassword'];
    $userId = $_POST['user-id'];

    // fetching expire time
    $sql = $conn->prepare("SELECT * FROM forgotpassword WHERE user_id = ?");
    $sql->bind_param("i", $userId);
    $sql->execute();
    $res = $sql->get_result();
    $ans = $res->fetch_assoc();

    $current_time = date("H:i:s");
    $expire_time = $ans['expire_time'];

    // checking if the time interval is valid
    if ($current_time > $expire_time) {

        $sql = $conn->prepare("DELETE FROM forgotpassword WHERE user_id = ?");
        $sql->bind_param("i", $userId);
        $sql->execute();

        header("Location: fpemail.php?info=expired");
        exit;
    }

        if ($pass == $con_pass) {

            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
            $sql = $conn->prepare("UPDATE userdetails SET password = ? WHERE user_id = ?");
            $sql->bind_param("si", $hashed_password, $userId);
            $sql->execute();
    
            header("Location: login.php?info=resetdone");
            exit;
        }
    
    }
    




  





// if (isset($_POST['pass_reset'])) {
//     $pass = $_POST['password'];
//     $con_pass = $_POST['confirmPassword'];
//     $userId = $_POST['user-id'];

//     // fetching expire time
//     $sql = $conn->prepare("SELECT * FROM forgotpassword WHERE user_id = ?");
//     $sql->bind_param("i", $userId);
//     $sql->execute();
//     $res = $sql->get_result();
//     $ans = $res->fetch_assoc();

//     $current_time = date("H:i:s");
//     $expire_time = $ans['expire_time'];

//     // checking if the time interval is valid
//     if ($current_time > $expire_time) {

//         $sql = $conn->prepare("DELETE FROM forgotpassword WHERE user_id = ?");
//         $sql->bind_param("i", $userId);
//         $sql->execute();

//         header("Location: fpemail.php?info=expired");
//         exit;
//     }

//     if ($pass == $con_pass) {

//         $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

//         $sql = $conn->prepare("UPDATE userdetails SET password = ? WHERE user_id = ?");
//         $sql->bind_param("si", $hashed_password, $userId);
//         $sql->execute();

//         header("Location: login.php?info=resetdone");
//         exit;
//     } else {
//         header("Location: passwordReset.php?id=$userId&info=mismatch");
//         exit;
//     }
// }
