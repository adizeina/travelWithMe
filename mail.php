<?php

// site used for help: https://blog.mailtrap.io/php-email-contact-form/
// work on it 

use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ . '/vendor/autoload.php';

$errors = [];
$errorMessage = '';

if (!empty($_POST)) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }
    if (empty($subject)) {
        $errors[] = 'Subject is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }


    if (!empty($errors)) {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
    } else {
        $mail = new PHPMailer();

        // specify SMTP credentials----Figure it out zeina!!!!

        $mail->setFrom($email, 'Mailtrap Website');
        $mail->addAddress('zeina.adi@mail.utoronto.ca', 'Me');
        $mail->Subject = 'New message from your website';

        // Enable HTML if needed --> What does this mean ??
        $mail->isHTML(true);

        $bodyParagraphs = ["Name: {$name}", "Subject:{$subject}","Email: {$email}", "Message:", nl2br($message)];
        $body = join('<br />', $bodyParagraphs);
        $mail->Body = $body;

        echo $body;
        if($mail->send()){

            header('Location: thank-you.html'); // redirect to 'thank you' page  --> I don't have one, put a "Thank you for your submission" text in green out!!!!!
        } else {
            $errorMessage = 'Oops, something went wrong. Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}

?>