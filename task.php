<?php
include('conn.php');
session_start();

if (isset($_POST['add'])) {
    $task = $_POST['task'];
    if ($task != NULL) {
        $query = "INSERT INTO `table_task` (task) VALUES ( '$task' )";
        mysqli_query($conn, $query);
        $_SESSION['succeed'] = true;
        header("Location: index.php");
    } else {
        $_SESSION['failed'] = "Silahkan Masukkan Teks Terlebih Dahulu";
        header("Location: index.php");
    }
}

if (isset($_POST['delete'])) {
    $id_delete = $_POST['id'];
    $status = $_POST['status'];
    $query = "DELETE FROM table_task WHERE id_task = $id_delete && status = $status";
    mysqli_query($conn, $query);
    header("Location: index.php");
}

if (isset($_POST['succeed'])) {
    $id_update = $_POST['id'];
    $query = "UPDATE table_task SET status = 1 WHERE id_task = $id_update";
    mysqli_query($conn, $query);
    header("Location: index.php");
}

if(isset($_POST['deleteAll'])) {
    $query = "DELETE FROM table_task WHERE status = 1";
    mysqli_query($conn, $query);
    header("Location: index.php");
}