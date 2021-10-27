<!DOCTYPE html>

<link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']).'Css/style.css' ?>">

<?php
    require_once 'fonctions.php';

    
    #Array for record of error codes
    $errors = [];
    #If the user name and the password are not empty we continue
    if(isset($_POST['new_user_name']) || isset($_POST['new_user_password']))
    {
        $errors[] = 1;
    }
    #If the user name is too big or use non valid characters we add an error
    if(strlen($_POST['new_user_name'])>40 || !preg_match('/^[a-zA-Z- ]+$', $_POST['name'])){
        $errors[] = 2;
    }
    #If the password is too long, too short, don't contain atleast one lower and upper case and one special char we add an error
    if(strlen($_POST['new_user_password'])>255 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,}/', $_POST['new_user_password'])){
        $errors[] = 3;
    }
    #If bad confirm password add an error
    if(!isset($_POST['new_user_password_confirm']) || $_POST['new_user_password'] != $_POST['new_user_password'])
    {
        $errors[] = 4;
    }
    if (user_exists_name($_POST['user_name'])){
        $errors[] = 5;
    
    }
    #If there is no errors, then we can go for the insert
    if(!count($errors) == 0){
        #We check if the token is okay
        if(isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])){
            #If the user doesn't exists we can and
            echo "Ok2";   
            $req = add_user($_POST['new_user_name'], $_POST['new_user_password']);
            #Check if the request has ended succesfully
            if($req != -1){
                $errors[] = 0;
            }else{
                $errors[] = 6;
            }      
            header('Location: index.php');
        }
    }
     
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription</title>
    </head>

    <body>
        
        <img width="150" height="100" src="up8.jpg">
        <form action="Add_Form.php" method="post">
            <div>
                <label for="name">Identifiant :</label>
                <input type="text" id="Iden" name="new_user_name">
            </div>

            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="new_user_password">
            </div>

            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="confirm-password" name="new_user_password_confirm">
            </div>

            <input type="hidden" name="csrf_token" id="hiddenField" value="<?php echo createToken();?>">

             
            <div class="button">
                <button type="submit">OK</button>
            </div>

            <div class="button">
                <button type="reset">Reset</button>
            </div>
        </form>
        <form action="index.php">
            <input type="submit" value="Acceuil" />
        </form>
        

        



    </body>
</html>
