<?php
require_once "vendor/autoload.php";

require_once "./class/Mail/PHPMailer/src/Exception.php";
require_once "./class/Mail/PHPMailer/src/PHPMailer.php";
require_once "./class/Mail/PHPMailer/src/SMTP.php";

use Foot\Connection;
use Foot\ForbiddenException;
use PHPMailer\PHPMailer\PHPMailer;
use Foot\Mail\Mail;
use Foot\Table\Exception\NotFoundException;
use Foot\User\UserTable;

if(!empty($_GET['code']) && !empty($_GET['id']) && isset($_GET['code'], $_GET['id'])) {
    $pdo = Connection::getPDO();
    $table = new UserTable($pdo);
    $code = htmlspecialchars($_GET['code']);
    $id = htmlspecialchars($_GET['id']);
    try {
        $u = $table->find($id);
        $inscriptionDateTime = $u->getInscription_date()->format('Y-m-d H:i:s');
        $expireDateTime = new DateTime($inscriptionDateTime);
        $expireDateTime->modify('+2 hours');
        $expireDateTime->format('Y-m-d H:i:s');
        $currentDateTime = new DateTime();
        if($currentDateTime > $expireDateTime) {
            $expired = "Lien expiré";
            if($u->getActivate !== 1) {
                $table->delete($id);
            }
        }
        else {  
            if($code === $u->getCode() && $u->getActivate() !== 1) {
                $u->setActivate(1);
                $table->updateUser($u);
                $phpmailer = new PHPMailer();
                $mail = new Mail($phpmailer);
                $body = "<!DOCTYPE html>
                    <html lang=\"fr\">
                        <body>
                            <h1>Inscription sur Footista</h1>
                            <img src=\"cid:logo_site\">
                            <h2>Bienvenue {$u->getUsername()} !</h2>
                            <p>Votre compte est maintenant activé !</p>
                            <p>Vous retrouverez et découvrerez toutes les informations concernant vos envies sur le football ! A tout de suite sur notre site !</p>
                            <p>Vous pouvez dès à présent vous <a href=\"https://footista.alwaysdata.net/\">connecter</a>.</p>
                        </body>
                    </html>";
                $mail->sendMail($body, 'sitefootista@gmail.com', 'Footista', $u->getMail(), 'Inscription Footista');
                header("refresh:3;url=login.php");
            }
        }
    } catch (NotFoundException $e) {
    } catch (Exception $e) {
        $e->getMessage();
    }
} 
else {
    //throw new ForbiddenException("Vous n'êtes pas autorisé à accéder à cette page.");
    header('Location: login.php?forbid=1');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- méta-données -->
        <title>Activation compte - Footista</title>
        <meta name="author" content="nathan"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"/>
        <link type="text/css" rel="stylesheet" title="standard" href="styles.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <link rel="icon" href="./images/favicon.ico"/>  
    </head>
    <body class="svg-center">
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
        </svg>
        <?php
        if(isset($expired)) {
            echo "<div id=\"wrapper\" class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
            <svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>
        </div>
        <div>
            {$expired}
        </div>\n";
        }
        else {
            echo "<div class=\"checked-center\">
            <svg id=\"successAnimation\" class=\"animated\" width=\"120\" height=\"120\" viewBox=\"0 0 70 70\">
                <path id=\"successAnimationResult\" fill=\"#D8D8D8\" d=\"M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z\"/>
                <circle id=\"successAnimationCircle\" cx=\"35\" cy=\"35\" r=\"24\" stroke=\"#979797\" stroke-width=\"2\" stroke-linecap=\"round\" fill=\"transparent\"/>
                <polyline id=\"successAnimationCheck\" stroke=\"#979797\" stroke-width=\"2\" points=\"23 34 34 43 47 27\" fill=\"transparent\"/>
            </svg>
        </div>
        <div class=\"checked-text\">
            Votre compte a été activé !
        </div>\n";
        }
        ?>
    </body>
</html>