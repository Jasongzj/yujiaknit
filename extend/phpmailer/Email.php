<?php
/**
 * 发送邮件类库
 * Created by PhpStorm.
 * User: Asa Ho
 * Date: 2017/9/6
 * Time: 22:09
 */
namespace phpmailer;
use phpmailer\Phpmailer;
use think\Exception;
class Email{
    /**
     * @param $to
     * @param $title
     * @param $content
     * @return bool
     */
    public static function send($to,$title,$content){
        date_default_timezone_set('PRC');//set time
        if(empty($to)){
            return false;
        }
        try {
            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use Smtp
            $mail->isSMTP();
            //Enable Smtp debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            //$mail->SMTPDebug = 2;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = config('email.host');
            //Set the Smtp port number - likely to be 25, 465 or 587
            $mail->Port = config('email.port');
            //Whether to use Smtp authentication
            $mail->SMTPAuth = true;
            //Username to use for Smtp authentication
            $mail->Username = config('email.username');
            //Password to use for Smtp authentication
            $mail->Password = config('email.password');
            //Set who the message is to be sent from
            $mail->setFrom(config('email.username'), 'Asa Ho');
            //Set an alternative reply-to address
            //$mail->addReplyTo('replyto@example.com', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress ($to);
            //Set the subject line
            $mail->Subject = $title;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($content);
            //Replace the plain text body with one created manually
            //$mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
                return false;
            } else {
                //echo "Message sent success!";
                return true;
            }
        }catch (phpmailerException $e){
            return false;
        }
    }
}