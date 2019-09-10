<?php
$lots_without_winner = get_lots_without_winner($con);

if(!isset($lots_without_winner)) {
    exit;
}

$recipients = [];

foreach($lots_without_winner as $lot) {
    $winner_id = get_lot_bids($con, $lot["id"])[0]["user_id"];
    $winner_email = get_lot_bids($con, $lot["id"])[0]["candidat_email"];
    $recipients[$user['email']] = $user['name'];
    
}

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
    $transport->setUserName("keks@phpdemo.ru");
    $transport->setPassword("htmlacademy");

    $message = new Swift_Message();
    $message->setSubject("");
    $message->setBody("Вашу гифку «Кот и пылесос» посмотрело больше 1 млн!");
    $message->setFrom("keks@phpdemo.ru", "YetiCave");
    $message->setBcc($recipients);

    $content = include_template("email.php", ['gifs' => $gifs]);


    $mailer = new Swift_Mailer($transport);
    $mailer->send($message);
    
    mail_winner($winner_email);