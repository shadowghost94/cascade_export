<?php
    include "../database/db.php";
    if(isset($_SESSION['id'])){
        header('location: ../article');
    }
    if(isset($_POST['inscrire'])){
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $email=$_POST['email'];
        $adresse=$_POST['adresse'];
        $contact=$_POST['contact'];
        $passe=$_POST['passe'];
        $confirmpasse=$_POST['confirmpasse'];
        $classe=$_POST['classe'];

        if(isset($nom,$prenom,$email,$classe,$adresse,$contact,$passe,$confirmpasse) and !empty($nom)
         and !empty($prenom) and !empty($email) and !empty($classe) and !empty($adresse) 
        and !empty($contact) and !empty($passe) and !empty($confirmpasse)){

            if(filter_var($email,FILTER_VALIDATE_EMAIL)){

                if($passe==$confirmpasse){
                    $reqEmail= $db->prepare('SELECT count("*") FROM users WHERE email=?');
                    $reqEmail->execute(array($email));
                    $resEmail=$reqEmail->fetch();

                    if($resEmail['count']==0){
                        $passHash=password_hash($passe,PASSWORD_DEFAULT);
                        $reqInsert= $db->prepare("INSERT INTO users (nom, prenom, email, classe, contact, adresse, password, date_inscription) VALUES(?,?,?,?,?,?,?,now())");
                        $reqInsert->execute(array($nom,$prenom,$email,$classe,$contact,$adresse,$passHash));
                    }
                    $msg="<label style='color:green;'>Information enregistrée avec succès !</label>";
                }else{
                    $msg="<label>Mot de passe ne correspond pas ! </label>";
                }
            }else{
                $msg="<label>E-mail invalide</label>";
            }
        }else{
            $msg="<label style='color:red;'>Veuillez renseigner tous les champs</label>";
        }
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
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
                            };
                        ?>
                    </div>
                    <div>
                        <label>Inscription</label>
                    </div>
                    <div>
                        <input class="input"  type="text" name="nom" placeholder="Nom" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="text" name="prenom" placeholder="Prénom(s)" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="email" name="email" placeholder="Email" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="text" name="classe" placeholder="Votre Classe" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="text" name="adresse" placeholder="Adresse" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="text" name="contact" placeholder="Contact" autofocus autocomplete="off">
                    </div>
                    <div>
                        <input class="input"   type="password" name="passe" placeholder="Mot de Passe" autocomplete="off">
                    </div>
                    <div>
                        <input class="input"   type="password" name="confirmpasse" placeholder="Confirmation mot de Passe" autocomplete="off">
                    </div>
                    <div>
                        <input class="input"  type="submit" name="inscrire" value="S'inscrire">
                    </div>
                </div>
            </form>
		</div>
	</body>
</html>