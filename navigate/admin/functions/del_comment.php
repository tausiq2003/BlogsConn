<?php

require_once "db.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "UPDATE comments SET status = 0 WHERE bid = ?";
    
    $stmt = $connection->prepare($sql);
    
    try {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header('Location: ../comments.php?deleted');
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header('Location: ../comments.php?del_error');
    exit();
}
?>
