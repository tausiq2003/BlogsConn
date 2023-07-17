<?php
    include "dbLogic.php";

    if (isset($_REQUEST['comment-btn'])){

        // mysql prepared statements
        $sql = $conn->prepare("INSERT INTO comments(comment, uid, bid, likes) VALUES(?, ?, ?, ?)");
        $sql->bind_param("siii", $content, $userId, $blogId, $likes);

        $content = $_POST['comment-box'];
        if (trim($content) == '') {
            // Comment is blank
            echo"
            <script>
               alert('Please enter a comment');
               window.history.back();
            </script>";
        } else {
        $userId = $_POST['user-id'];
        $blogId = $_POST['blog-id'];
        $likes = 0;

        $sql->execute();

        header("Location: blogPage.php?id=$blogId&user_id=$userId?ADD");
        exit;
    }
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "comment") {
        $id = $_GET['id'];
        
        // Check if user has already liked the comment
        if (isset($_COOKIE["liked_comment_$id"])) {
            // User has already liked the comment, do not allow another like
            echo"<script>window.history.back()</script>";
            exit;
        }
        
        // Get the current like count
        $sql = $conn->prepare("SELECT likes FROM comments WHERE id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        $ans = $result->fetch_assoc();
        $like_count = $ans['likes'];
        
        // Increase the like count
        $like_count = $like_count + 1;
        
        // Update the database with the new like count
        $sqlInsert = $conn->prepare("UPDATE comments SET likes = ? WHERE id = ?");
        $sqlInsert->bind_param("ii", $like_count, $id);
        $sqlInsert->execute();
        
        // Set a cookie to mark that the user has liked this comment
        setcookie("liked_comment_$id", true, time() + (86400 * 30), "/"); // Cookie lasts for 30 days
        
        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

?>