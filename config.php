<?php
$host = 'localhost';
$db = 'techblog';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function uploadFile($file, $targetDir = 'uploads/') {
    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return false;
}
?>