<?php
include "db_conn.php";
session_start();

if (isset($_POST['userName']) && isset($_POST['passWord'])) {
    $user = trim($_POST['userName']);
    $passWord = trim($_POST['passWord']);

    // Check and report error message to index view
    if (empty($user)) {
        header("Location: index.php?Msg=Username is required to Login");
        exit();
    } else if (empty($passWord)) {
        header("Location: index.php?Msg=Password is required to Login");
        exit();
    } else {

        $sql = "SELECT * FROM users WHERE username='$user'";

        $queryResult = mysqli_query($connection, $sql);

        $row = mysqli_fetch_assoc($queryResult);

        if ($row == null) {
            header("Location: index.php?Msg=User does not exist, Try Again!!!");
            exit();
        } else {


            // Compare blocked untill with time from database
            $time = strtotime($row['blocked']);
            $curtime = time();
            if ($curtime > $time) {

                // check password match
                if ($row['password'] == $passWord) {
                    $sqlUp = "UPDATE `users` SET `failed_time` = '0' WHERE username='$user'";
                    mysqli_query($connection, $sqlUp);
                    $_SESSION['loggedInUser'] = $row['username'];
                    header("Location: articles.php");
                } else {

                    // If password don't match update failed atempt in database, If reaching 3 attempts block the user for 60 sec
                    $logFail = $row['failed_time'];

                    if ($logFail >= 2) {

                        block($user, $connection);
                    } else {


                        $logFail++;
                        if ($logFail < 3) {

                            $sqlUp = "UPDATE `users` SET `failed_time` = '$logFail' WHERE username='$user'";
                            if (mysqli_query($connection, $sqlUp)) {
                                header("Location: index.php?Msg=Login failed!!");
                                exit();
                            } else {
                                header("Location: index.php?Msg=Timed Out! Error updating record: " . mysqli_error($connection));
                                exit();
                            }
                        } else {

                            block($user, $connection);

                        }
                    }
                }
            } else {
                $x = $row['blocked'];
                echo "You are blocked until $x";
            }
        }


    }
} else {
    header("Location: index.php");
    exit();
}

// this method blocks the user 60 seconds and update the time in the current users database
function block($user, $connection)
{
    $my_date = date("Y-m-d H:i:s", time() + 60);
    $sqlUp = "UPDATE `users` SET `blocked` = '$my_date' WHERE username='$user'";
    if (mysqli_query($connection, $sqlUp)) {
        header("Location: index.php?Msg=Login failed, blocked for 60 seconds!!");
        exit();
    } else {
        header("Location: index.php?Msg=Timed Out! Error updating record: " . mysqli_error($connection));
        exit();
    }
};

?>

