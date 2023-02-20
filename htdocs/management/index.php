<?php
$servername = "localhost";
$username = "root";
$password = "root";
$conn = mysqli_connect($servername, $username, $password,"project");
$dd = date("d");
$mm = date("m") + 1;
$yy = date("Y");

if(isset($_POST["stdi"]))
{
    $sql = "SELECT * FROM studentnames where stdid = " . $_POST["stdi"];
    $result = mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
</head>
<style>
    #head,#form{
        max-width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    #form{
        font-size: 24px;
        margin-top:80px;
    }

    input[type="submit"],#stdi{
        font-size:24px;
    }

    table, th, td {
        font-size: 24px;
        height: 30px;
        /* border: 1px solid black; */
        border-collapse: collapse;
    }

    tr:nth-child(even) {
        background-color: #ddd;
    }

    td{
        width:50%;
        text-align: center;
    }

    table{
        /* border: 1px solid black; */
        margin-top:80px;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

</style>
<body>
    <div id="head">
        <h1>Student Management</h1>
    </div>
    <div id="form">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="stdi">Enter student number to search : </label>
            <input type="text" name="stdi" id="stdi">
            <input type="submit" value="Submit">
        </form>
    </div>
    <div id="content">
        <table>
            <tr>
                <td>Student ID:</td>
                <td><?php
                if(isset($_POST["stdi"]))
                {
                    if (mysqli_num_rows($result) > 0) 
                    {
                        $row = mysqli_fetch_assoc($result);
                        echo $row["stdid"];
                    }
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>Student Name:</td>
                <td><?php
                if(isset($_POST["stdi"]))
                {
                    if (mysqli_num_rows($result) > 0) 
                    {
                        echo $row["name"];
                    }
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>Class:</td>
                <td><?php
                if(isset($_POST["stdi"]))
                {
                    if (mysqli_num_rows($result) > 0)
                    {
                        echo $row["class"];
                    }
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>No of days present : </td>
                <td><?php
                if(isset($_POST["stdi"]))
                {   
                    if (mysqli_num_rows($result) > 0)
                    {
                        $sql = "SELECT count(*) FROM logindetails where stdid = " . strval($row["stdid"]) . " and login between \"" . date("Y-m") . "-01\"" . " and \"" . date("Y-m-d") . "\"";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                            $row = mysqli_fetch_assoc($result);
                            echo $row["count(*)"];
                        }
                    }
                    else
                    {
                        echo "<script>alert(\"No Student found for the particular Id\");</script>";
                    }
                }
                ?>
                </td>
            </tr>
        </table>
    </div>    
</body>
</html>