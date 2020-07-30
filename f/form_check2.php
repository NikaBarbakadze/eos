<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//
//
require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';



$bank_name=$_POST["bank_name"];
$valute=$_POST["valute"];
$cource=$_POST["cource"];
$amount=$_POST["amount"];
$bank_acc=$_POST["bank_acc"];
$info_acc=$_POST["info_acc"];
$sended=$_POST["sended"];
$date = date("Y-m-d h:i:s");
$I_RATE=0;
include __DIR__ . "/conn.php";


$sql = "SELECT  Currnet_rate FROM rates WHERE VALUTE='{$_POST['valute']}'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $I_RATE= $row["Currnet_rate"];
    }
}else{}

$profit=(floatval($amount)*floatval($cource))-(floatval($amount)*floatval($I_RATE));




$sql2 = "INSERT INTO main (BANK, SOURCE, FAMOUNT,DEST,TAMOUNT,I_BAN,U_BAN,TIME,I_RATE,O_RATE,APPROVEL,PROFIT) VALUES ('{$bank_name}', 'GEL',{$amount}, '{$valute}',{$sended},'{$bank_acc}','GE80TB2455USD','{$date}',{$I_RATE},'{$cource}',0,'{$profit}')";
$result = $conn->query($sql2);
$last_id = $conn->insert_id;
if($result)
{

    $mail = new PHPMailer(true);
    try {

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                   // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'oesphpmailer@gmail.com';                     // SMTP username
        $mail->Password = '1mf83kt4RDg';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


        $mail->setFrom('talelishvili@mdf.org.ge', 'Mailer');
        $mail->addAddress('talelishvili@mdf.org.ge', 'OES');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        //  $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');


        //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name


        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Add tranzaction';
        $mail->Body = 'შემოვიდა განაცხადი მოთხოვნით'. $bank_name ." ის ანგარიშიდან სურთ " . $valute . " რაოდენობით :".$amount ."   ანგარიშზე : ".$bank_acc;
       // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
    echo $last_id;

}
else
{
    echo 0;

}



?>