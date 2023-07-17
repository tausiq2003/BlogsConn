
<?php 

    include "dbLogic.php";
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    if (isset($_GET['type'], $_GET['id'], $_GET['user_id'])){

        // Deleting a like
        // mysql prepared statements
        $sql = $conn->prepare("SELECT id FROM blog_likes WHERE (user = ? AND blog = ?)");
        $sql->bind_param("ii", $loggedInUser, $id);
        $type = $_GET['type'];
        $id = $_GET['id'];
        $userId = $_GET['user_id'];
        $loggedInUser = $_SESSION['uid'];
        $sql->execute();
        $result = $sql->get_result();
        $ans = mysqli_num_rows($result);


        if ($ans === 1){
            $sql = "DELETE FROM blog_likes WHERE (user = $loggedInUser AND blog = $id)";
            mysqli_query($conn, $sql);
            header("Location: blogPage.php?id=$id&user_id=$userId&disliked");
            exit;
        }
        
        // Inserting a like
        if ($type == "article"){
            $sql = "INSERT INTO blog_likes(user, blog)
                        SELECT {$_SESSION['uid']}, {$id}
                        FROM blogsdata
                        WHERE EXISTS (
                            SELECT id FROM blogsdata WHERE id = {$id})
                        AND NOT EXISTS (
                            SELECT id FROM blog_likes 
                            WHERE user = {$_SESSION['uid']}
                            AND blog = {$id})
                        LIMIT 1 ";
            // $_SESSION['uid'] will be stored in user column and
            // $id is the blog-id which will be stored in blog column
            mysqli_query($conn, $sql);
                    
        }

        header("Location: blogPage.php?id=$id&user_id=$userId");
    }

?>
