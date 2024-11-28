<?php
session_start();
include "connectScriptforDB.php";


if (!isset($_SESSION['employee_id'])) {
    header(header: "Location: login.php");
    exit();
}

$employee_name = $_SESSION['employee_name'];
$employee_id = $_SESSION['employee_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voter_id = $employee_id;
    $nominee_id = $_POST['nominee_id'];
    $category_id = $_POST['category_id'];
    $comment = $_POST['comment'];

    if ($voter_id == $nominee_id) {
        echo "Invalid vote";
        exit();
    }
    $sql = "INSERT INTO votes (voter_id, nominee_id, category_id, comment) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare(query: $sql);
    $stmt->bind_param("iiis", $voter_id, $nominee_id, $category_id, $comment);

    if ($stmt->execute()) {
        echo "<p>Vote submitted !</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
$category_result = $connection->query(query: "SELECT category_id, category_name FROM categories");
$employee_result = $connection->query(query: "SELECT employee_id, employee_name FROM employees");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
</head>
<style>
    body
    {
        background-image: linear-gradient(white, lightcyan);
        height: 100vh;
        font-family:arial;
    }
    #voteKey{
        width:100px;
        height:50px;
        background-color: lightcyan;
        font-weight:bold;
        border:1px solid black;
        border-radius: 10px;
        box-shadow: 20px  black;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
    }
    #resultKey{
        width:100px;
        height:50px;
        background-color: lightcyan;
        font-weight:bold;
        border:1px solid black;
        margin-left:700px;
        border-radius: 10px;
        box-shadow: 20px  black;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
    }
    #container
    {
        background-image: linear-gradient(lightcyan,lightblue);
        font-family:arial;
        border-radius: 50px;
        border: 2px solid black;
        text-align: center;
        font-size: large;
        width:900px;
        box-shadow: 0 30px 30px rgba(0, 0, 0, 0.1);
        margin-left:270px;
        margin-top:60px;
    }
    textarea{
        border-radius: 10px;
        width:300px;
        height:200px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border:2px solid black;
    }
    select{
        
        border-radius: 10px;
        background-color: lightcyan;
        text-align: center;
        border:2px solid black;
    }
    select:hover{
        background-image: linear-gradient(white,lightcyan);
    }
    option{
        
        background-image: linear-gradient(white,lightcyan);
    }
    #signedInStatus{
        font-weight:lighter;
        box-shadow: 0 0px 10px rgba(0, 0, 0, 0.1);
        background-image: linear-gradient(lightcyan,white);
        border: 2px solid black;
        width:250px;
        height:25px;
        font-size: larger;
        border-radius: 20px;
        text-align: center;
    }
</style>

<script>


</script>
<body>
    <h2 id="signedInStatus">Signed in as: <?php  echo htmlspecialchars(string: $employee_name);   ?></h2>
<form action = 'votingpage.php' method="POST">
    <div id = container>
        <br>
    <label for="category_id">Choose a Category:</label><br><br>
            <select name="category_id" id="category_id" required>
            <option value="">Select Category</option>
             
            
            <?php 
                while ($rows = $category_result->fetch_assoc()) {
                    $category_id = $rows['category_id']; 
                    $category_name = $rows['category_name'];
                    echo "<option value='$category_id'>$category_name</option>";
                }
                ?>*/
            </select>
<br><br>
            <label for="nominee_id">Choose a Nominee:</label><br><br>
            <select name="nominee_id" id="nominee_id"  required >
                <option value="">Select Nominee</option>
                
            <?php 
                while ($rows = $employee_result->fetch_assoc()) {
                    $employee_id = $rows['employee_id']; 
                    $employee_name = $rows['employee_name'];
                    echo "<option value='$employee_id'>$employee_name</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <div>
            <label for="comment">Your Comment*</label><br>
            <textarea name="comment" id="comment" rows="4" required></textarea>
        </div>
<br>
        <button type="submit" id="voteKey">Submit Vote</button>
        <br>
        <button type="submit" id="resultKey" onclick="window.location.href='resultspage.php';">View Results</button>
<br>
<br>
        </div>
    
</body>
</html>