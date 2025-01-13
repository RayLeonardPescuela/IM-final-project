<?php
$conn = new mysqli('localhost', 'root', '', 'im_pescuela');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$gid = $_GET['gid'];
$result = $conn->query("SELECT * FROM ig WHERE gid=$gid");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $regiment = $_POST['regiment'];
    $spec = $_POST['spec'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE ig SET name=?, rank=?, regiment=?, spec=?, status=? WHERE gid=?");
    $stmt->bind_param("sssssi", $name, $rank, $regiment, $spec, $status, $gid);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Member</title>
</head>
<body>
    <section class="main-container">
        <header>
            <h1>Edit Member Information</h1>
        </header>
        <form method="post" action="" class="edit-form">
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" placeholder="Name" required>
            <input type="text" name="rank" value="<?= htmlspecialchars($row['rank']) ?>" placeholder="Rank" required>
            <input type="text" name="regiment" value="<?= htmlspecialchars($row['regiment']) ?>" placeholder="Regiment" required>
            <input type="text" name="spec" value="<?= htmlspecialchars($row['spec']) ?>" placeholder="Specialization" required>
            <input type="text" name="status" value="<?= htmlspecialchars($row['status']) ?>" placeholder="Status" required>
            <button type="submit">Save Changes</button>
        </form>
    </section>
</body>
</html>
