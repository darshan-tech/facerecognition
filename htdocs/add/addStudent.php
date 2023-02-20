<?php

$flag1 = 0;
$flag = 0;
$servername = "localhost";
$username = "root";
$password = "root";
$conn = mysqli_connect($servername, $username, $password,"project");

$uploaddir = "../StudentImages/";
$imageFileType = strtolower(pathinfo($_FILES['uimg']['name'],PATHINFO_EXTENSION));
$uploadfile = $uploaddir . $_POST["uid"] . "." . $imageFileType;

$tmp = $_POST['uid'] . ",\"" . $_POST['uname'] . "\",\"" . $_POST["uid"] . "." . $imageFileType . "\",\"" . strtoupper($_POST['clas'])  . "\")"; 
$stmt = "INSERT INTO studentnames VALUES(" . $tmp;

$sql = "SELECT stdid FROM studentnames";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    if($row["stdid"]==$_POST['uid'])
    {
      $flag1 = 1;
    }
  }
} 

if($flag1==0){
  if (move_uploaded_file($_FILES['uimg']['tmp_name'], $uploadfile)) {
    $flag=1;
    mysqli_query($conn,$stmt);
  } else {
    $flag=0;
  }
}
else{
  $flag=0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
</head>
<body>
    Upload result : <?php echo $flag ?>
</body>
</html>