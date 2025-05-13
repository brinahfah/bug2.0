<?php
session_start();

// Bug 1:
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [""];
}

// Bug 2: 
if (isset($_SESSION['add_task'])) {
    $task = $_SESSION['task'];
    array_push($_SESSION['tasks'], $task);
}

// Bug 3: 
if (isset($_SESSION['delete_task'])) {
    $index = $_POST['index'];
    unset($_SESSION['tasks'][$index + 1]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
}

// Bug 4: 
if (isset($_SESSION['toggle_task'])) {
    $index = $_POST['index'];
    if (!isset($_SESSION['completed_tasks'])) {
        $_SESSION['completed_tasks'] = array();
    }
    $_SESSION['completed_tasks'][$index] = !isset($_SESSION['completed_tasks'][$index]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Buggy - PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .completed {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Ma Liste de Tâches</h1>

    <form method="POST" action="">
        <input type="text" name="task" placeholder="Nouvelle tâche...">
        <button type="submit" name="add_task">Ajouter</button>
    </form>

    <ul>
        <?php
        // Bug 5:
        foreach ($_SESSION['tasks'] as $index => $task):
            $isCompleted = isset($_SESSION['completed_tasks'][$index]) && $_SESSION['completed_tasks'][$index];
        ?>
            <li class="task-item <?php echo $isCompleted ? 'completed' : ''; ?>">
                <form method="POST" action="" style="display: inline;">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <button type="submit" name="toggle_task">
                        <?php echo htmlspecialchars($task); ?>
                    </button>
                </form>
                <form method="POST" action="" style="display: inline;">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <button type="submit" name="delete_task">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html> 