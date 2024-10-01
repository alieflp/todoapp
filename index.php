<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">

        <!-- Menampilkan pesan sukses atau gagal -->
        <?php if (isset($_SESSION['message'])) : ?> 
            <div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['type']);
            ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-dark text-white">To-Do List</div>
            <div class="card-body">

                <?php
                // Cek apakah kita sedang dalam mode edit
                $edit_mode = false;
                $edit_id = -1;
                if (isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $edit_mode = true;
                    $task = $_SESSION['tasks'][$edit_id];
                }
                ?>
                <form method="POST" action="action.php">
                    <input type="hidden" name="edit_id" value="<?= $edit_mode ? $edit_id : -1; ?>">
                    
                    <div class="mb-3">
                        <label for="task" class="form-label">Task</label>
                        <input type="text" class="form-control" name="task" value="<?= $edit_mode ? $task['task'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="Low" <?= $edit_mode && $task['priority'] == 'Low' ? 'selected' : ''; ?>>Low</option>
                            <option value="Medium" <?= $edit_mode && $task['priority'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="High" <?= $edit_mode && $task['priority'] == 'High' ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary w-100 mt-2"><?= $edit_mode ? 'Update' : 'Add Task'; ?></button>
                </form>
            </div>
        </div>

        <!-- Daftar Tasks -->
        <div class="mt-5">
            <h3>Daftar Tasks</h3>
            <?php if (!empty($_SESSION['tasks'])): ?>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                            <tr>
                                <td><?= $task['task']; ?></td>
                                <td><?= $task['priority']; ?></td>
                                <td>
                                    <a href="index.php?edit=<?= $index; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="action.php?delete=<?= $index; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus task ini?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Belum ada task.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
