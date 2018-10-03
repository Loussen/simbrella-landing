<?php
require "phpmailer_mailer/class.phpmailer.php";

?>

<?php

$response = json_encode(array("code"=>0, "content" => "Error system", "err_param" => ''));

if($_POST)
{
    if($_POST['apply_form_file'])
    {
        $_POST = array_map("strip_tags", $_POST);
        extract($_POST);

        if(strlen($name)<3)
            $response = json_encode(array("code"=>0, "content" => "Error name", "err_param" => 'name'));
        elseif(strlen($surname)<3)
            $response = json_encode(array("code"=>0, "content" => "Error surname", "err_param" => 'surname'));
        elseif(strlen($email)<3 || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $response = json_encode(array("code"=>0, "content" => "Error email", "err_param" => 'email'));
        elseif(strlen($agree)<3)
            $response = json_encode(array("code"=>11, "content" => "Error agree", "err_param" => 'agree'));
        else
        {
            $mail = new PHPMailer();
            $mail -> IsSMTP();
            $mail->SMTPDebug = 1;
            $mail -> SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail -> Host = 'smtp.gmail.com';
            $mail -> Port = 465;
            $mail -> Username = 'simbrellacampaign@gmail.com';
            $mail -> Password = '159357sn!)(';
            $mail -> AddReplyTo("simbrellacampaign@gmail.com","Simbrella");
            $mail -> SetFrom($mail -> Username, 'Simbrella');
            $mail -> AddAddress($email);

            $mail -> CharSet = 'UTF-8';
            $mail -> Subject = 'PDF file';

            $message = 'Hello! <br /><br />
Here is your copy of " Simbrella SimKredit™ ARPU Increase Case Study ".
Please click this link to download: <br /><br />
Link
<br /><br />
Best regards,<br />
Simbrella team<br /><br />
--
This e-mail was sent after filling in ARPU increase case study request form on simbrella.com';

            $mail -> MsgHTML($message);

            $mail_own = new PHPMailer();
            $mail_own -> IsSMTP();
            $mail_own->SMTPDebug = 1;
            $mail_own -> SMTPAuth = true;
            $mail_own->SMTPSecure = 'ssl';
            $mail_own -> Host = 'smtp.gmail.com';
            $mail_own -> Port = 465;
            $mail_own -> Username = 'simbrellacampaign@gmail.com';
            $mail_own -> Password = '159357sn!)(';
            $mail_own -> AddReplyTo("simbrellacampaign@gmail.com","Simbrella");
            $mail_own -> SetFrom($mail -> Username, 'Simbrella');
            $mail_own -> AddAddress("simbrellacampaign@gmail.com");

            $mail_own -> CharSet = 'UTF-8';
            $mail_own -> Subject = 'PDF file';

            $message = 'Name: '.$name.'<br />
                        Surname: '.$surname.'<br />
                        Email: '.$email;

            $mail_own -> MsgHTML($message);

            if($mail->Send() && $mail_own->Send())
                $response = json_encode(array("code"=>1, "content" => "Success", "err_param" => ''));
            else
                $response = json_encode(array("code"=>-1, "content" => "Try again", "err_param" => ''));
        }
    }
}

echo $response;
?>