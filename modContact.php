<?php

// if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0)
// {
//     //require("load_user_db.php");
//     $user = trim($_POST['signinuser']);
//
//     $query = "SELECT * FROM user_info WHERE username='$user'";
//     $statement = $db->prepare($query);
//     $statement->execute();
//     $result = $statement->fetch();
// }

$nameresult="";
if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['contactname']) > 0)
{
    require("load_user_db.php");
    $contact = trim($_POST['contactname']);
    //$user=$_SESSION['user'];
    //$query = "SELECT * FROM $_SESSION['user'] WHERE Name='$contact'";
    $query = "SELECT * FROM loganhylton99 WHERE Name='$contact'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    if (strlen($result['Name']) > 0){
        $nameresult=$result['Name'];
    } else{
        $nameresult="No names found";
    }
}
// if(array_key_exists('checkContacts', $_POST)) {
//             getContact();
// }
//
// if(array_key_exists('changeBday', $_POST)) {
//             changeBday();
// }

function getContact(){
    echo $_POST["username"];
}

function changeBday(){
    echo $_POST["newBday"];
}

?>
