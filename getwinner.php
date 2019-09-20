<?php
$lots_without_winner = get_lots_without_winner($con);
/*
if(!empty($lots_without_winner)) {
    $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
    $transport->setUserName("keks@phpdemo.ru");
    $transport->setPassword("htmlacademy");

    $mailer = new Swift_Mailer($transport);

    foreach($lots_without_winner as $lot) {
        [
            "last_bid_user_id" => $winner_id,
            "last_bid_user_name" => $winner_name,
            "last_bid_user_email" => $winner_email,
        ] = $lot;

        update_lot_winner($con, $winner_id, $lot["id"]);

        $message = new Swift_Message();
        $message->setFrom("keks@phpdemo.ru", "YetiCave");
        $message->setTo([$winner_email => $winner_name]);
        $message->setSubject("Вы стали победителем на интернет-аукционе Yeticave!");

        $email_content = include_template("email.php", [
            "winner_name" => $winner_name,
            "lot" => $lot
        ]);
        $message->setBody($email_content, "text/html");

        $mailer->send($message);
    }
}

*/





