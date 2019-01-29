<?php

/* Esto recibimos del html */

$asunto     = $_POST['category'];
$email      = $_POST['email'];
$nombre     = $_POST['name'];
$mensaje    = $_POST['message'];


// If there is missing some parameter then return to the contact page.
if (!isset($_POST['category']) || !isset($_POST['email']) || !isset($_POST['message']) || !isset($_POST['name'])) {
    
    header("Location:../contacto.php?errorNoExists");
    exit();
}

// If the message is empty then return to the contact page.
if ($mensaje == "") {
    header("Location:../contacto.php?error");
    exit();
    return;
}

// Perform a request to send the email to the address of Alianza.
// If everything is fine then return to the contact page with the header parameter 'enviado'
// Otherwise return with the error
if (SendEmailToClient($email, $mensaje, $asunto, $nombre)) {
    header("Location:../contacto.php?enviado");
} else {
    header("Location:../contacto.php?error");
}

// Function SendEmailToClient
// Sends an email to one customer.
function SendEmailToClient($email, $mensaje, $asunto, $nombre)
{
    require_once('PHPMailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    
    $body = "El usuario: <strong>" . $nombre . "</strong> ha reportado lo siguiente: <br/><br/>" . $mensaje; // <br/><br/>Para responder, por favor clickea ac�: <a href='mailto:" . $email . "'> Responder</a>";
    
    try {
        $mail->IsSMTP();

        // Setting the credentials of the server.
        $mail->Host     = "";
        $mail->SMTPAuth = true;
        $mail->Username = "";
        $mail->Password = "";
        $mail->Port     = "25";
        
        // Setting the information of the user.
        $mail->SetFrom("");
        $mail->AddAddress("");
        $mail->AddReplyTo($email, "Information");
        
        // Setting the body and the subject of the mail.
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $body;
        
        // Send the mail
        // If ocurred an exception then return false
        // Otherwise return true.
        if (!$mail->send()) {
            echo "Message error";
            echo "Mail Exception -> " . $mail->ErrorInfo;
            return false;
        } 

        return true;
        
    }
    catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
        return false;
    }
    catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
        return false;
    }
} 
?>
