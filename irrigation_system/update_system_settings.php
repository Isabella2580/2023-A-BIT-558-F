<?php
include('db.php');

$irrigation_threshold = $_POST['threshold'];
$irrigation_status = $_POST['status'];

$sql = "UPDATE system_settings SET irrigation_threshold = ?, irrigation_status = ? WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $irrigation_threshold, $irrigation_status);
$stmt->execute();

echo "Settings updated successfully!";
?>
