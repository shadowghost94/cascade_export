<?php
    include '../database/db.php';
    if(isset($_SESSION['id'])){
        header('location: ../article');
    }

    if(isset($_POST['connecter'])){
        $email=$_POST['email'];
        $passe=$_POST['passe'];

        if(isset($email,$passe) and !empty($email) and !empty($passe)){
            $req= $db->prepare('SELECT *,count("*") AS ct FROM users WHERE email=?');
            $req->execute(array($email));
            $res=$req->fetch();

            if($res['ct']>0){
                $verif_password=password_verify($passe, $res['password']);
                if($verif_password){
                    $_SESSION['id']=$res['id'];
                    $_SESSION['nom']=$res['nom'];
                    $_SESSION['prenom']=$res['prenom'];
                    $_SESSION['email']=$res['email'];

                    header('location: ../article');
                }else{
                    $msg="<label style='color: red;'>E-mail ou mot de passe Incorrect</label>";    
                }
            }else{
                $msg="<label style='color: red;'>E-mail ou mot de passe Incorrect</label>";    
            }
        }else{
            $msg="<label style='color: red;'>Veullez renseigner tous les champs</label>";
        }
    }

    
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Connexion</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../assets/css/connect.css">
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" href="../assets/css/main.css">
	</head>
	<body class="corps_connexion">
        <div>
            <form method="POST" action="">
                <div class="connexion">
                    <div>
                        <?php
                            if(isset($msg)){
                                echo $msg;
                            }
                        ?>
                    </div>
                    <div>
                        <label>Connexion</label>
                    </div>
                    <div>
                        <input class="input"   type="email" name="email" placeholder="Email" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"    type="password" name="passe" placeholder="Mot de Passe" autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="submit" name="connecter" value="Se connecter">
                    </div>
                </div>
            </form>
		</div>
	</body>
</html>