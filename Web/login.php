<?php
require_once "vendor/autoload.php";

require_once "./class/Mail/PHPMailer/src/Exception.php";
require_once "./class/Mail/PHPMailer/src/PHPMailer.php";
require_once "./class/Mail/PHPMailer/src/SMTP.php";

use Foot\Connection;
use Foot\Mail\Mail;
use Foot\Table\Exception\NotFoundException;
use Foot\User\User;
use Foot\User\UserTable;
use PHPMailer\PHPMailer\PHPMailer;

$user = new User();
$error = false;
$newerror = false;

$phpmailer = new PHPMailer();
$mail = new Mail($phpmailer);

if(!empty($_POST)) {    
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $user->setUsername(htmlspecialchars($_POST['username']));
        $pdo = Connection::getPDO();
        $table = new UserTable($pdo);
        try {
            $u = $table->findbyUsername(htmlspecialchars($_POST['username']));
            if((password_verify(htmlspecialchars($_POST['password']), $u->getPassword()) === true) && $u->getActivate() === 1) {
                session_start();
                $_SESSION['auth'] = $u->getId();
                header("Location: index.php?login=1");
                exit();
            }    
        } catch (NotFoundException $e) {
        }
        $error = true;
    }
    else if(!empty($_POST['newuser']) && !empty($_POST['newmail']) && !empty($_POST['newpass']) && !empty($_POST['confnewpass'])) {
        $pdo = Connection::getPDO();
        $table = new UserTable($pdo);
        $password = password_hash(htmlspecialchars($_POST['newpass']), PASSWORD_BCRYPT);
        if(password_verify(htmlspecialchars($_POST['confnewpass']), $password)) {
            $user->setUsername(htmlspecialchars($_POST['newuser']));
            $user->setMail(htmlspecialchars($_POST['newmail']));
            $user->setPassword($password);
            $user->setCode(md5(hash('whirlpool',md5(substr(md5(date('Y-h-s-i')), 0, -24)))));
            $table->createUser($user);
            $phpmailer = new PHPMailer();
            $mail = new Mail($phpmailer);
            $body = "<!DOCTYPE html>
            <html lang=\"fr\">
                <body>
                    <h1>Confirmation mail pour Footista</h1>
                    <img src=\"cid:logo_site\">
                    <p>Activez votre compte en validant votre email <a href=\"https://footista.alwaysdata.net/activation.php?code={$user->getCode()}&id={$user->getId()}\">ici</a> pour avoir accès à votre compte.</p>
                </body>
            </html>";
            $mail->sendMail($body, 'sitefootista@gmail.com', 'Footista', $user->getMail(), 'Confirmation mail Footista');
            $activate = "Activez votre compte par le biais du mail qui vous à été envoyé !";
            header("Location: login.php?active=1");
            exit();
        }
        $newerror = true;
    }
}

require_once "./include/header.inc.php";
?>
    <section class="login-section">
        <div class="container">
            <div class="user signinBx">
                <div class="imgBx"><img src="./images/img-login.jpg" alt="image login"/></div>
                <div class="formBx">
                    <form action="#" method="POST">
                    <?php
                    if(isset($_GET['active']) && $newerror === false) {
                        echo "<div class='alert alert-success'>Activez votre compte par le biais du mail qui vous à été envoyé !</div>\n";
                    }
                    ?>
                        <h2>Se connecter</h2>
                        <input type="text" name="username" placeholder="Identifiant" required="required"/>
                        <input type="password" name="password" placeholder="Mot de passe" required="required"/>
                        <input type="submit" value="Se connecter"/>
                        <p class="signup">Pas encore de compte ? <a href="#" id="link-signup">S'inscrire</a></p>
                    </form>
                </div>
            </div>

            <div class="user signupBx">
                <div class="formBx">
                    <form action="#" method="POST">
                        <h2>Créer un compte</h2>
                        <input type="text" name="newuser" placeholder="Identifiant" required="required"/>
                        <input type="email" name="newmail" placeholder="Adresse e-mail" required="required"/>
                        <input type="password" name="newpass" placeholder="Mot de passe" required="required"/>
                        <input type="password" name="confnewpass" placeholder="Confirmer mot de passe" required="required"/>
                        <input type="submit" value="S'inscrire"/>
                        <p class="signup">Déjà inscrit ? <a href="#" id="link-signin">Se connecter</a></p>
                    </form>
                </div>
                <div class="imgBx"><img src="./images/img-login2.jpg" alt="image login"/></div>
            </div>            
        </div>
    </section>

<?php
require_once "./include/footer.inc.php";
?>