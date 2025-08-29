<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends Controller
{

    public function sendMail( $array ) {
        // die();
    	// if( !isset( $array['to'], $array['name'], $array['subject'], $array['message'] ) ){

    	// 	return false;
     //    }

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = "mail.logodost.com";  // specify main and backup server
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = "noreply@logodost.com";  // SMTP username
            $mail->Password = "2vAu!)#eMqEA"; // SMTP password

            $mail->From     = "noreply@logodost.com";
            $mail->FromName = "Rainbow";
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->AddAddress("mohitranaok@gmail.com", "Rainbow");
            $mail->AddAddress($array['email'], "Rainbow");

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $array['subject'];
            $mail->Body    = $array['message'];
            $mail->addAttachment($array['path']);
          

            if($mail->send()){
               // dd('all good');
            }else{
               // dd('all not good');
            }
            return true;
        }
        catch (Exception $e) {
            dd($e);
            return false;
        }
    }

}