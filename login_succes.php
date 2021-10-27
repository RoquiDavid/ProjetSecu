<?php
    session_start();
    print("k");
    echo '<h3>Login Success, Welcome - '.$_SESSION["user_name"].'</h3>';  
    echo '<br /><br /><a href="logout.php">Logout</a>';  
?>