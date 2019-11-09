<?php

    $sqlQuery = "SELECT * FROM users WHERE username = :username";
    $statement = $DB_NAME->prepare($sqlQuery);
    $statement->execute(array(':username' => $user));
    // $sql = "SELECT * FROM user";
    // $result = mysqli_query($conn, $sql);
    if ($statement->rowCount() > 0)
    {
        while ($row = $statement->fetch())
        {
            $id = $row['id'];
            $sqlImg = "SELECT * FROM profileimg WHERE userid='$id'";
            $resultImg = $DB_NAME->prepare($sqlImg);
            $resultImg->execute(array(':userid' => $id));

            //$resultImg = mysqli_query($conn, $sqlImg);
            while ($rowImg = $resultImg->fetch())
            {
                echo "<div class ='user-container'>";
                if($rowImg['status'] == 0)
                {
                    echo "<img src='uploads/profile".$id.".jpg?'".my_rand().">";
                }
                else
                {
                    echo "<img src='uploads/profiledefault.jpg?'".my_rand().">";
                }
                echo "<p>".$row['username']."</p>";
                echo "</div>";
            }
        }
    }
    else
    {
        echo "THere are no users yet!";
    }
    if (isset($_SESSION['id']))
    {
        if($_SESSION['id'] == 1)
        {
            $esult = flashMessage("You are logged is as user #1");
        }
        echo "<form action='' method='POST' enctype='multipart/form-data'>
        <table>
            <input type='file' name='file'>
            <button type='submit' name='upload'>upload</button>
        </table>
        </form>";
        echo "<form action='' method='POST' enctype='multipart/form-data'>
        <table>
            <input type='file' name='file'>
            <button type='submit' name='Delete'>Delete</button>
        </table>
        </form>";
    }
    else
    {
        $result = flashMessage("You are not logged in.");
        $result = flashMessage("Not yet a member? <a href='signup.php'>signup</a>");
    }

    if(isset($result)) echo $result;
    if(!empty($form_errors)) echo show_errors($form_errors);

?>

<?PHP 
    $sessionid = $_SESSION['id'];

    $filename = "uploads/profile".$sessionid."*";
    $fileinfo = glob($filename);
    $fileext = explode(".", $fileinfo[0]);
    $fileactualext = $fileext[1];

    $file = "uploads/profile".$sessionid.".".$fileactualext;

    if (!unlink($file))
    {
        $result = flashMessage("file was not deleted!");
    }
    else
    {
        $result = flashMessage("file was deleted!");
    }

    $sql = "UPDATE profileimg SET status=1 WHERE userid='$sessionid'";
    redirectTo('index');
?>