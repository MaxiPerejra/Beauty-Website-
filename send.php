<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['error' => 'Metoda niedozwolona']);
    exit;
}


$name    = strip_tags(trim($_POST['name']    ?? ''));
$phone   = strip_tags(trim($_POST['phone']   ?? ''));
$email   = filter_var(trim($_POST['email']  ?? ''), FILTER_VALIDATE_EMAIL);
$message = trim($_POST['message'] ?? '');

if (!$name || !$phone || !$email || !$message) {
    http_response_code(422);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['error' => 'Wypełnij wszystkie pola poprawnie.']);
    exit;
}


try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USER'];     
    $mail->Password   = $_ENV['MAIL_PASS'];    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom($email, $name);
    $mail->addAddress('makskunikowski@gmail.com');

    $mail->isHTML(false);
    $mail->Subject = "Wiadomosc od $name";
    $mail->Body    = "Imię: $name\nTelefon: $phone\nE-mail: $email\n\n$message";

    $mail->send();


    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['success' => true]);
    exit;

} catch (Exception $e) {

    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
      'error' => 'Nie udało się wysłać wiadomości.',
      'details' => $mail->ErrorInfo
    ]);
    exit;
}
