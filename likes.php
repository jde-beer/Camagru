<?php

if(!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

if(isset($_POST['button'])) {
    ++$_SESSION['counter'];
}
if(isset($_POST['reset'])) {
    $_SESSION['counter'] = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="counter" value="<?php echo $_SESSION['counter']; ?>" />
        <input type="submit" name="button" value="Counter" />
        <input type="submit" name="reset" value="Reset" />
        <br/><?php echo $_SESSION['counter']; ?>
    </form>
    
</body>
</html>