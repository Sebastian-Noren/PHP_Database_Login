<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 4 - Login</title>
</head>

<body>

    <form action="login.php" method="post">
        <h2>Login Window</h2>
        <?php
        if(isset($_GET['Msg'])){ ?>
        <p><?php echo $_GET['Msg'];?></p>
        <?php }; ?>
        <input type="text" name="userName" placeholder="Username">
        <input type="password" name="passWord" placeholder="Password">
        <button type="submit">Login</button>
    </form>

</body>

</html>