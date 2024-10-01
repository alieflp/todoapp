<?php
session_start();

// Jika form disubmit untuk menambah atau mengedit task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $edit_id = $_POST['edit_id'];

    if ($edit_id != -1) {
        // Update task yang sudah ada
        $_SESSION['tasks'][$edit_id] = [
            'task' => $task,
            'priority' => $priority
        ];
        $_SESSION['message'] = "Task berhasil diperbarui!";
        $_SESSION['type'] = "success";
    } else {
        // Tambah task baru
        $_SESSION['tasks'][] = [
            'task' => $task,
            'priority' => $priority
        ];
        $_SESSION['message'] = "Task berhasil ditambahkan!";
        $_SESSION['type'] = "success";
    }

    header('Location: index.php');
    exit();
}

// Jika request adalah untuk menghapus task
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    unset($_SESSION['tasks'][$delete_id]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reset array index
    $_SESSION['message'] = "Task berhasil dihapus!";
    $_SESSION['type'] = "danger";

    header('Location: index.php');
    exit();
}
?>
