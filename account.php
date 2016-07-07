<?php
//extract Form data
extract($_POST);

//create a database connection.
$link = mysqli_connect("swmonkcom.ipagemysql.com", "swmonk", "cmpe285", "sportshop");
if($link === false){
    die("ERROR: Could not connect to database <br><br> " . mysqli_connect_error());
}

//Retrieve records from buyer table based on user id
$sql1 = "SELECT * FROM buyer WHERE userid = '$userid'";
$result1 = mysqli_query($link, $sql1);  
if($result1) {
    if(mysqli_num_rows($result1) > 0) {
    while($row = mysqli_fetch_array($result1)) {
            //retrieve records if user id and password match
            if($row['userid'] === $userid) {
                if($row['password'] === $pwd) { 
                    echo 'Hi <b><font color="MidnightBlue">' . $row['userid'] . '</font></b>! Welcome Back!<br><br>';
                    echo '<b>First Name :: </b>' . $row['fname'];
                    echo '<br><br>';
                    echo '<b>Last Name :: </b>' . $row['lname'];
                    echo '<br><br>';
                    echo '<b>Address :: </b>' . $row['addr'];
                    echo '<br><br>';
                    echo '<b>Email :: </b>' . $row['email'];
                    echo '<br><br>';
                    echo '<b>Cell Number :: </b>' . $row['cell'];
                    echo '<br><br>';
                    echo '<b>Home Number :: </b>' . $row['home'];
                    echo '<h1>Purchase History </h1>';
                    $sql2 = "SELECT * FROM purchase_history WHERE userid = '$userid'";
                    $result2 = mysqli_query($link, $sql2);  
                    if($result2) {
                        if(mysqli_num_rows($result2) > 0) {
                            echo '<table>';
                            echo '<tr>';
                            echo '<th><b>Product Name</b></th>';
                            echo '<th><b>Purchase Date</b></th>';
                            echo '<th><b>Quantity</b></th>';
                            echo '</tr>';
                            while($row1 = mysqli_fetch_array($result2)) {
                                echo '<tr>';
                                echo '<td>' . $row1['prod_name'] . '</td>';
                                echo '<td>' . $row1['purchase_date'] . '</td>';
                                echo '<td>' . $row1['quantity'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                        }
                        else {
                            echo '<br>No purchase has been made yet! Start Shopping now!<br>';
                        }

                        //close the result sets
                        mysqli_free_result($result1);
                        mysqli_free_result($result2);
                    }
                    echo '<br><br><a href="http://www.swmonk.com/home/">Logout</a>';
                } 
                //else display an appropriate error message
                else {
                    echo '<font color="red">Check your password!</font><br><br><br>You were denied access by the server due to incorrect password!<br><br><br>';
                    echo '<a href="http://www.swmonk.com/account/">Login Again</a>';
                }   
            }            
        }
    } 
    //display an error message if user id does not exist
    else {
        echo '<font color="red">Permission denied!</font><br><br><br>Username does not exist! You were denied access by the server.<br><br><br>';
        echo '<a href="http://www.swmonk.com/userreg/">Register Here</a>';
    }
}

//close the database connection
mysqli_close($link);

?>