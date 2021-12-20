<?php
namespace Foot\Mail;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'FootConf.conf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Foot\FootConf;

class Mail {

    private $mail;

    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
    }

    public function sendMail(string $body, string $from, string $fromName, string $to, string $subject)
    {

        $this->mail->IsSMTP();
        $this->mail->Host = 'smtp.gmail.com';               //Adresse IP ou DNS du serveur SMTP
        $this->mail->Port = 465;                          //Port TCP du serveur SMTP
        $this->mail->SMTPAuth = 1;                        //Utiliser l'identification
        $this->mail->CharSet = 'UTF-8';
        
        if($this->mail->SMTPAuth) {
            $this->mail->SMTPSecure = 'ssl';               //Protocole de sécurisation des échanges avec le SMTP
            $this->mail->Username   =  FootConf::$smtpUser;    //Adresse email à utiliser
            $this->mail->Password   =  FootConf::$smtpPassword;         //Mot de passe de l'adresse email à utiliser
        }
        
     /*A modifier afin de mettre avec la bd ou non*/   
        $this->mail->setFrom(trim($from), $fromName);                //L'email à afficher pour l'envoi
        
        $this->mail->AddAddress($to);

        $this->mail->isHTML(true);
        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo.png';
        $this->mail->AddEmbeddedImage($path, "logo_site");       
        $this->mail->Subject    =  $subject;                      //Le sujet du mail
        $this->mail->WordWrap   = 50; 			       //Nombre de caracteres pour le retour a la ligne automatique
        $this->mail->Body = $body; 	       //Texte brut

        if (!$this->mail->send()) {
            throw new \Exception($this->mail->ErrorInfo);
        }
    }
}
?>
