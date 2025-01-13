<?php
$conn = new mysqli('localhost', 'root', '', 'im_pescuela');

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$gid = $_GET['gid'];
$conn->query("DELETE FROM ig WHERE gid=$gid");
header("Location: index.php");
exit();
?>
