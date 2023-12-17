<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public $status;
    private $mail, $message, $mail_from, $mail_to, $mail_cc, $mail_bcc, $mail_subject, $mail_body, $attach;

    public function __construct(){
        $this->status = 1;
        $this->message = "";
        $this->mail_cc = [];
        $this->mail_bcc = [];
        $this->mail_to = [];
        $this->attach = [];

        //Create an instance; passing `true` enables exceptions
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->isSMTP();
        $this->mail->Host       = env("MAIL_HOST");
        $this->mail->SMTPAuth   = true;
        $this->mail->SMTPAutoTLS = false;
        $this->mail->Username   = env("MAIL_USERNAME");
        $this->mail->Password   = env("MAIL_PASSWORD");
        $this->mail->SMTPSecure = strtolower(env("MAIL_SECURE"))=='ssl'?PHPMailer::ENCRYPTION_SMTPS:PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = env("MAIL_PORT");
        $this->mail->isHTML(true);
    }

    public function debug(){
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        return $this;
    }

    public function from($email,$title=null){
        $this->mail_from = [
            'email' => $email,
            'title' => $title??null,
        ];
        return $this;
    }

    public function cc($email,$title=null){
        $this->mail_cc[] = [
            'email' => $email,
            'title' => $title??null,
        ];
        return $this;
    }

    public function bcc($email,$title=null){
        $this->mail_bcc[] = [
            'email' => $email,
            'title' => $title??null,
        ];
        return $this;
    }

    public function to($email,$title=null){
        $this->mail_to[] = [
            'email' => $email,
            'title' => $title??null,
        ];
        return $this;
    }

    public function attachment($path){
        $this->attach[] = $path;
        return $this;
    }

    public function body($body=null){
        $this->mail_body = $body;
        return $this;
    }

    public function subject($subject=null){
        $this->mail_subject = $subject;
        return $this;
    }

    public function send(){
        try {
            if($this->mail_from){
                if($this->mail_from['title']){
                    $this->mail->setFrom($this->mail_from['email'], $this->mail_from['title']);
                } else {
                    $this->mail->setFrom($this->mail_from['email']);
                }
                if(count($this->mail_to) > 0){
                    foreach($this->mail_to as $i => $mailTo){
                        if($mailTo['title']){
                            $this->mail->addAddress($mailTo['email'], $mailTo['title']);
                        } else {
                            $this->mail->addAddress($mailTo['email']);
                        }
                    }
                    
                    // $mail->addReplyTo('info@example.com', 'Information');
                    
                    if(count($this->mail_cc) > 0){
                        foreach($this->mail_cc as $i => $mailTo){
                            if($mailTo['title']){
                                $this->mail->addCC($mailTo['email'], $mailTo['title']);
                            } else {
                                $this->mail->addCC($mailTo['email']);
                            }
                        }
                    }
                    
                    if(count($this->mail_bcc) > 0){
                        foreach($this->mail_bcc as $i => $mailTo){
                            if($mailTo['title']){
                                $this->mail->addBCC($mailTo['email'], $mailTo['title']);
                            } else {
                                $this->mail->addBCC($mailTo['email']);
                            }
                        }
                    }
                    
                    if(count($this->attach) > 0){
                        foreach($this->attach as $i => $path){
                            $this->mail->addAttachment($path);
                        }
                    }
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                    
                    if($this->mail_subject){
                        if($this->mail_body){
                            //Content
                            $this->mail->isHTML(true);
                            $this->mail->Subject = $this->mail_subject;
                            $this->mail->Body    = $this->mail_body;
                            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                            $ret = $this->mail->send();

                            $this->message = 'Message has been sent';
                            $this->status = 1;
                        } else {
                            $this->message = 'Set mail body ( $[params]->body([html]) )';
                            $this->status = 0;
                        }
                    } else {
                        $this->message = 'Set mail subject ( $[params]->subject([string]) )';
                        $this->status = 0;
                    }
                } else {
                    $this->message = 'Set mail to ( $[params]->to([email],[title]) )';
                    $this->status = 0;
                }
            } else {
                $this->message = 'Set mail from ( $[params]->from([email],[title]) )';
                $this->status = 0;
            }
        } catch (Exception $e) {
            $this->message = "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            $this->status = 0;

            $this->debug();
            \Log::debug(json_encode($this->mail->SMTPDebug));
            \Log::debug($this->mail->ErrorInfo);
        }
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }
}