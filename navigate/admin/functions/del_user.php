<?php

require_once "db.php";

if (isset($_POST["user_id"])) {
    $id = $_POST["user_id"];
    $sql = "UPDATE userdetails SET status = 0 WHERE user_id = ?";
    
    $stmt = $connection->prepare($sql);
    
    try {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header('Location: ../user.php?deleted');
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header('Location: ../user.php?del_error');
    exit();
}
?>