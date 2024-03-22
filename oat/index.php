<?php include 'filesLogic.php';
// Add Prefix
function genRandomString() {
    $length = 10;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $string;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="/oat/style.css">
    <title>Files Upload and Download</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">Upload</button>
          <input type="hidden" name="myfile_newname" value="<?php print genRandomString(); ?>.jpg" />
        </form>
        <div style="display:flex; justify-content: center; align-items: center;" class="row">
            <!-- Button to lead to download page -->
            <button style="margin-top:10px;" onclick="window.location.href='/oat/downloads.php';">Download</button>
        </div>
      </div>
    </div>
  </body>
</html>
