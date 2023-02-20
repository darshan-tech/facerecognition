<?php
$servername = "localhost";
$username = "root";
$password = "root";
$conn = mysqli_connect($servername, $username, $password,"project");

if(isset($_POST["del"]))
{
    $sql = "SELECT file FROM studentnames where stdid = " . $_POST['del'];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $row = mysqli_fetch_assoc($result);
        if(file_exists("../StudentImages/" . $row["file"]))
            {
                unlink("../StudentImages/" . $row["file"]);
            }
            $sql = "DELETE FROM studentnames where stdid = " . $_POST['del'];
            $result = mysqli_query($conn, $sql);
            $sql = "DELETE FROM logindetails where stdid = " . $_POST['del'];
            $result = mysqli_query($conn, $sql);
        }
}

$sql = "SELECT * FROM studentnames";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove User</title>
</head>
<style>
    
    #head{
        max-width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    table, th, td {
        font-size: 20px;
        height: 30px;
        /* border: 1px solid black; */
        border-collapse: collapse;
    }

    tr:nth-child(even) {
        background-color: #ddd;
    }

    input[type=submit]
    {
        font-size:18px;
    }

    td{

        text-align: center;
    }

    table{
        margin-top:80px;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

</style>
<body>
    <div id="head">
        <h1>Remove User</h1>
    </div>
    <div class="main">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Student Id</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Delete</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $tmp = "<tr><td>" . $row["stdid"] ."</td><td>". $row["name"] . "</td><td>" . $row["class"] . "</td><td><input type=\"submit\" value=\"" .$row["stdid"] . "\" name=\"del\"></td></tr>";
                        echo $tmp;
                    }
                }
                else{
                    echo "<tr><td colspan=\"4\">No Student found</td></tr>";
                }
                ?>
            </table>
        </form>
    </div>
    
</body>
</html>