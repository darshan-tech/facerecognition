<?php
$servername = "localhost";
$username = "root";
$password = "root";
$conn = mysqli_connect($servername, $username, $password,"project");

$sql = "SELECT * FROM logindetails order by login desc";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Details</title>
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
        border-collapse: collapse;
    }

    tr:nth-child(even) {
        background-color: #ddd;
    }

    th {
        position: sticky;
        background-color: white;
        z-index: 2;
        top: 0;
    }

    td{

        text-align: center;
    }

    table{
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .main{
        margin-top:80px;
        overflow:hidden;
        height: 200px;
        overflow-y: scroll;
    }

    #cont2{
        margin-top: 80px;
        overflow:hidden;
        height: 200px;
        overflow-y: scroll;
    }

</style>
<body>
    <div id="head">
        <h1>Student Login Details</h1>
    </div>
    <div class="main">
        <table>
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Login Time</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $tmp = "<tr><td>" . $row["stdid"] ."</td><td>". $row["name"] . "</td><td>" . $row["login"] . "</td></tr>";
                    echo $tmp;
                }
            }
            else{
                echo "<tr><td colspan=\"3\">No Student Record found</td></tr>";
            }
            ?>
        </table>
    </div>
    <div id="cont2">
        <table>
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Total Attendance</th>
            </tr>
            <?php
                $sql = "SELECT * FROM studentnames";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT count(*) FROM logindetails where stdid = " . strval($row["stdid"]);
                        $res = mysqli_query($conn,$sql);
                        $row1 = mysqli_fetch_assoc($res);
                        $tmp = "<tr><td>" . $row["stdid"] ."</td><td>". $row["name"] . "</td><td>" . $row1["count(*)"] . "</td></tr>";
                        echo $tmp;
                    }
                }
                else{
                    echo "<tr><td colspan=\"3\">No Student Record found</td></tr>";
                }
            ?>
        </table>
    </div>
</body>
</html>