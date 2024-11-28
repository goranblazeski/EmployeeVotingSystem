<?php
session_start();
include "connectScriptforDB.php";

// Ensure the database connection is working
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
        c.category_name, 
        e.employee_name AS winner_name, 
        v.vote_count
    FROM 
        (SELECT category_id, nominee_id, COUNT(*) AS vote_count
         FROM votes
         GROUP BY category_id, nominee_id
        ) v
    JOIN 
        (SELECT category_id, MAX(vote_count) AS max_votes
         FROM (SELECT category_id, nominee_id, COUNT(*) AS vote_count
               FROM votes
               GROUP BY category_id, nominee_id
              ) AS vote_counts
         GROUP BY category_id
        ) mv
    ON v.category_id = mv.category_id AND v.vote_count = mv.max_votes
    JOIN categories c ON v.category_id = c.category_id
    JOIN employees e ON v.nominee_id = e.employee_id";

$winresult = $connection->query(query: $sql);

// Check for SQL query execution errors
if (!$winresult) {
    echo "Error: " . $connection->error;  // Display error message
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winners</title>
</head>
<style>

body{
    background-image:linear-gradient(lightskyblue,lightcyan,white);
    height:65vh;
}
#tableContainer{
    background-color: white;
    border: 2px solid black;
    font-family:arial;
    border-radius:10px;
    width:fit-content;
    height:fit-content;
    box-shadow: 0 30px 30px rgba(0, 0, 0, 0.1);
    margin-left:480px;
    margin-top:250px;
    text-align: center;
}
table{
    height:300px;
    width:500px;
}
thead {
        background-image: linear-gradient(lightcyan, white);
        color: black;
    }
    td {
        font-size: 16px;
        color: black;
        border: 1px solid darkgray;
        border-radius: 10px;
        font-size: 16px;
    }
    th {
        
        border:1px solid black;
        font-size: 18px;
        border-radius: 10px;
    }
    tbody tr:nth-child(even) {
        background-color: whitesmoke;
    }

    tbody tr:nth-child(odd) {
        background-color: lightcyan;
    }
</style>
<body>
    <div id="tableContainer">    <table>
    <thead>
        <th>Category</th>
        
        <th>Winner</th>
        
        <th>Votes</th>
    </thead>
    <tbody>
        <?php
    if ($winresult->num_rows > 0) {
                    while ($row = $winresult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['winner_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vote_count']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No votes have been cast yet.</td></tr>";
                }
    ?>
                </tbody>
    </table>
    </div>

</body>
</html>