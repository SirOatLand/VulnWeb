<?php include 'filesLogic.php';?>
<meta charset="utf-8" />
  <link rel="stylesheet" href="style.css">
  <title>Download files</title>
</head>
    <div id="logo"> 
        <img id="logo" src="./assets/pakjung.png" > 
    </div>
<body>

<table>
<thead>
    <th>ID</th>
    <th>Filename</th>
    <th>size (in KB)</th>
    <th>Downloads</th>
    <th>Action</th>
    <th>Preview</th>
</thead>
<tbody>
  <?php foreach ($files as $file): ?>
    <tr>
      <td style="text-align: center;"><?php echo $file['id']; ?></td>
      <td><?php echo $file['name']; ?></td>
      <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $file['downloads']; ?></td>
      <td style="text-align:center;"><button onclick="window.location.href='downloads.php?file_id=<?php echo $file['id']; ?>'">Download</button></td>
      <td style="text-align:center;"><button onclick="window.location.href='./uploads/<?php echo $file['name']; ?>'">Preview</button></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>

</body>
</html>
