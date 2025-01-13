<?php
$conn = new mysqli('localhost', 'root', '', 'im_pescuela');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $regiment = $_POST['regiment'];
    $spec = $_POST['spec'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO ig (name, rank, regiment, spec, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $rank, $regiment, $spec, $status);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM ig");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Imperial Guard Roster</title>
</head>
<body>
    <section class="main-container">
        <header>
            <h1>Imperial Guard Roster</h1>
        </header>
        <form method="post" action="" class="add-form">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="rank" placeholder="Rank" required>
            <input type="text" name="regiment" placeholder="Regiment" required>
            <input type="text" name="spec" placeholder="Specialization" required>
            <input type="text" name="status" placeholder="Status (e.g., Active)" required>
            <button type="submit">Add New Member</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>GID</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Regiment</th>
                    <th>Specialization</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['gid']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['rank']) ?></td>
                    <td><?= htmlspecialchars($row['regiment']) ?></td>
                    <td><?= htmlspecialchars($row['spec']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <a href="editguardview.php?gid=<?= $row['gid'] ?>" class="edit-link">Edit</a>
                        <a href="deleteguard.php?gid=<?= $row['gid'] ?>" class="delete-link" onclick="return confirm('Confirm deletion?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
