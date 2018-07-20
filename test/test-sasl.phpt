<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 19.07.18
 * Time: 11:59
 */


namespace Test;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Tester\Assert;

require __DIR__ . "/../vendor/autoload.php";


\Tester\Environment::setup();


// Testuser is user@domain.de:secret1 - Allowed



$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = "localhost";
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = 'user@domain.de';  // a valid email here
$mail->Password = 'secret1';  // the password from email
$mail->From = 'user@domain22.de';
$mail->SMTPDebug = true;
#$mail->AddReplyTo('from@xxx.com.br', 'Test');

#$mail->FromName = 'Test SMTP';
$mail->AddAddress('matthes@leuffen.de', 'matthes@leuffen.de');

$mail->Subject = 'Test SMTP';
$mail->IsHTML(true);
$mail->Body = '<b>Teste</b><br><h1>teste 2</h1>';
//$mail->Send();

Assert::exception(function () use ($mail) {
    $mail->Send();
}, Exception::class);


$mail->From = "user@domain.de";
Assert(true, $mail->Send());

$mail->Username = "user2@domain.de";
$mail->From = 'any@any.de';

Assert(true, $mail->Send());




