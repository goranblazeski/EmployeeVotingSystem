<?php
session_start();
include 'connectScriptforDB.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    /*
    $employee_id = $_POST['employee_id'];*/
    $employee_name = $_POST['employee_name'];

    $sql = "SELECT * FROM employees WHERE employee_name = ?";
    $stmt = $connection->prepare(query: $sql);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $storedstmt = $stmt->get_result();
    if ($storedstmt->num_rows > 0)
    {
        $employee = $storedstmt->fetch_assoc();
     
        $_SESSION['employee_id'] = $employee['employee_id']; 
        $_SESSION['employee_name'] = $employee['employee_name'];
        header(header: "Location: votingpage.php");
    }
    else
    {
        echo "Invalid Employee Credentials!";
    }

    $stmt->close();
    $connection->close();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<style>
    
    body{
        font-family:arial;
        background-image: linear-gradient(lightcyan, white);
        height:100vh;
    }
    #container{
        background-image: linear-gradient(lightcyan, lightskyblue);
        font-weight:lighter;
        margin-left:550px;
        margin-top:200px;
        width: 300px;
         box-shadow: 0 30px 30px rgba(0, 0, 0, 0.1);
        height: 120px;
        border:4px solid black;
        border-radius:20px;
        font-size:small;
        text-align:center;
    }
    input{
        border-radius: 10px;
        background-color: lightcyan;
        text-align: center;
        font-weight:bold;
    }
    #loginKey{
        width:100px;
        height:50px;
        background-color: lightcyan;
        font-weight:bold;
        border:3px solid black;
        border-radius: 10px;
        box-shadow: 20px  black;
    }
    ::placeholder{
        color:black;
        font-style: italic;
        font-weight:lighter;
    }
</style>
<body>
    <div id = 'container'>
        <br>
    <form action = 'login.php' method = 'POST'>
         <!-- <label for="employee_name">Enter Your Name:</label><br> -->
            <input type="text" id="employee_name" placeholder="Enter your name..." name="employee_name" required><br>
            <br>
            <button id="loginKey" type="submit">Log-in</button><br>
            
    </form>

    </div>
</body>
</html>