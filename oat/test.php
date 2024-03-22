<?php
$conn = mysqli_connect('localhost', 'root', 'sakjung', 'file-management');

$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);
echo $result

?>
