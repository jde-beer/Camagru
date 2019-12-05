<?PHP
include_once 'config/connect.php';
include_once 'config/utilities.php';

if (isset($_GET['token']) && !empty($_GET['token'])) 
{
    $token = htmlentities($_GET['token']);

    $sql = "SELECT * FROM users WHERE token='".$token."'";
    $sqlQuery = $DB_NAME->prepare($sql);
    $sqlQuery->execute();
    $row = $sqlQuery->fetch();

    if ($row > 0) 
    {
        if($row['verified'] == 'Y')
        {
            $result = flashMessage("The account has already been verified");
        }
        else
        {
            $query1 = "UPDATE users SET verified='Y' WHERE id = :id"; 
            $query = $DB_NAME->prepare($query1);
            $query->execute(array('id' => $row['id']));
            $result = flashMessage("Your acount has been verified, you can now login", "Pass");
        }
    } 
    else 
    {
        $result = flashMessage("The url is either invalid or you already verified your account.");
    }
}
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Meme(Me) - VERIFY</title>
    </head>
    <body>
        <div>VERIFY</div>
        <?php if(isset($result)) echo $result; ?>
    </body>
    <footer> &copy; Copyright Jde-beer <?php print date(" Y")?></footer>
</html>