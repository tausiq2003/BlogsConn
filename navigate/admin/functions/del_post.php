<?php

require_once "db.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    $sql = "UPDATE blogsdata 
    INNER JOIN comments ON blogsdata.id = comments.bid 
    SET blogsdata.status = 0, comments.status = 0 
    WHERE blogsdata.id = ?
    ";

    $stmt = $connection->prepare($sql);

    try {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header('Location: ../posts.php?deleted');
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header('Location: ../posts.php?del_error');
    exit();
}
?>