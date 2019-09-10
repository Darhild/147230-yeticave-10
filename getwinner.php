<?php
$lots_without_winner = get_lots_without_winner($con);

if(!isset($lots_without_winner)) {
    exit;
}

foreach($lots_without_winner as $lot) {
    if ($lot["bids_num"] > 0) {
        $winner = [];
        $winner["id"] = get_lot_bids($con, $lot["id"])[0]["user_id"];
        $winner["name"] = get_lot_bids($con, $lot["id"])[0]["candidat_name"];
        $winner["email"] = get_lot_bids($con, $lot["id"])[0]["candidat_email"];

//        $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
//        $transport->setUserName("keks@phpdemo.ru");
//        $transport->setPassword("htmlacademy");
//
//        $mailer = new Swift_Mailer($transport);
//
//        $message = new Swift_Message();
//        $message->setFrom("keks@phpdemo.ru", "YetiCave");
//        $message->setTo([$winner["email"] => $winner["name"]]);
//        $message->setSubject("Вы стали победителем на интернет-аукционе Yeticave!");
//
//        $email_content = include_template("email.php", [
//            "winner" => $winner,
//            "lot" => $lot
//        ]);
//        $message->setBody($email_content, "text/html");
//
//        $mailer->send($message);
    }
}




