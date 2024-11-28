<?php



    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'votesdb';
    
    $connection = mysqli_connect(hostname: $host,username: $user,password: $pass,database: $db);
    if(mysqli_connect_errno())
    {
        echo 'Connection failed' . mysqli_connect_error();
    }

    else if(mysqli_connect_errno()==0)
    {/*
        echo 'Connection succesful';*/
    }

  /*   $sql = "INSERT INTO employees(Name,Surname,Email)
            VALUES (?,?,?)";

            $stmnt = mysqli_stmt_init($connection);
   if(! mysqli_stmt_prepare($stmnt, $sql))
   {
    die(mysqli_error($connection));
   }
mysqli_stmt_bind_param($stmnt, "sss", $name, $surname,$email);
mysqli_stmt_execute($stmnt);
    }*/
    
?>