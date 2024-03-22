<?php
// connect to the database
$conn = mysqli_connect('localhost', 'root', 'sakjung', 'file-management');

$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $originalFilename = $_FILES['myfile']['name'];

    // get name with prefix
    $filenameWithPrefix = $_POST['myfile_newname'];

    // destination directory for uploaded files
    $uploadDirectory = './uploads/';

    // destination of the file on the server
    $destination = $uploadDirectory . $filenameWithPrefix;

    // get the file extension
    $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    // array of allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($extension, $allowedExtensions)) {
        echo "You file extension must be jpg, .jpeg, or .png";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1 Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads) VALUES ('$filenameWithPrefix', $size, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        
        //This part of code prevents files from being corrupted after download
        ob_clean();
        flush();
        
        readfile($filepath);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }
}
?>
