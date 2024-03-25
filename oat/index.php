<?php include 'filesLogic.php';
// Add Prefix
function genRandomString() {
    $length = 7;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";
    $time = time();

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return "[" . date("h:i:s",$time) . "] - " . $string;
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
        <div id="form">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">Upload</button>
          <input type="hidden" name="myfile_newname" value="<?php print genRandomString(); ?>.jpg" />
        </form>
          <button onclick="window.location.href='/oat/downloads.php';">Download</button>
        </div>
      </div>
    </div>
    <div id="logo"> 
        <img id="logo" src="./assets/pakjung.png" > 
    </div>
  </body>
</html>
