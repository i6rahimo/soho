<?php
// Файлы phpmailer
require 'assets/phpmailer/PHPMailer.php';
require 'assets/phpmailer/SMTP.php';
require 'assets/phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$nameCompany = $_POST['nameCompany'];
$name = $_POST['name'];
$email = $_POST['email'];

// Формирование самого письма
$title = "Оставить заявку";
$body = "
<h2>Новое письмо</h2>
<b>Имя:</b> $nameCompany<br></b>
<b>Телефон:</b> $name <br></b>
<b>Email:</b> $email<br></b>
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host       = 'smtp.yandex.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'sohoads@yandex.ru'; // Логин на почте
    $mail->Password   = 'yuztseucajmoeoaw'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('sohoads@yandex.ru', 'Оставить заявку'); // Адрес самой почты и имя отправителя

    // Получатель письма
    // $mail->addAddress('ibra210@yandex.ru');
    $mail->addAddress('sohoads@yandex.ru'); // Ещё один, если нужен
    $mail->addAddress('i6rahim210@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
    if (!empty($file['name'][0])) {
        for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
            $filename = $file['name'][$ct];
            if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
                $rfile[] = "Файл $filename прикреплён";
            } else {
                $rfile[] = "Не удалось прикрепить файл $filename";
            }
        }
    }
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отравленность сообщения
    if ($mail->send()) {
        $result = "success";
    } else {
        $result = "error";
    }
} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
// echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
