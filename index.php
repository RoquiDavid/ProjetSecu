<!DOCTYPE html>
<?php
    include 'fonctions.php';
    
    #Si on recoit bien les paramètre du formulaire d'ajout alors on appelle la fonction d'ajout

    try 
    {
        if( isset($_POST['user_name']) && $_POST['user_name']!="" && isset($_POST['user_password']) && $_POST['user_password']!="")
        {
            print("ok ". user_exists($_POST['user_name'], $_POST['user_password']));
            if (user_exists($_POST['user_name'], $_POST['user_password']))
            {
                print("connection ok");
                session_start();
                $_SESSION['user_name'] = $_POST['user_name'];
                $_SESSION['user_password'] = $_POST['user_password'];
                header("Location:login_succes.php");
            }
            else
            {
                $message = '<label>Faux</label>'; 
            }
        }

    }catch (PDOException $error)
    {
        $message = $error->getMessage(); 
    }
    

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content = "<?php echo createToken();?>"/> 
        <!--On utilise ici dirname pour donner le moins d'info possible à l'user sur l'archi de site-->
        <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']).'Css/style.css' ?>">
        <title>Connection</title>
    </head>

    <body>
        <img width="150" height="100" src="up8.jpg">
        <form action="index.php" method="post">
            <div>
                <label for="name">Identifiant :</label>
                <input type="text" id="Iden" name="user_name">
            </div>
            <div>
                <label for="mail">Mot de passe :</label>
                <input type="password" id="password" name="user_password">
            </div>

            <div class="button">
                <button type="submit">OK</button>
            </div>

            <div class="button">
                <button type="submit">Reset</button>
            </div>
             
        </form>

        <form action="Add_Form.php">
            <input type="submit" value="Inscription" />
        </form>
        


    </body>
</html>
