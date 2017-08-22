<?php
/**
 *  PHPMailer config
 */

date_default_timezone_set('Etc/UTC');

require_once('PHPMailer/PHPMailerAutoload.php');

// Fields picked from form
$name =     $_POST["name"];
$phone =    $_POST["phone"];
$email =    $_POST["email"];
$payment =  $_POST["payment"];
$gender =   $_POST["gender"];
$b_day =    $_POST["select_day"];
$b_month =  $_POST["select_month"];
$b_year =   $_POST["select_year"];
$from =     $_POST["recipient"];


// From
$recipient = "josh.nattrass@gmail.com";

$empty = array();

if (empty($name)) array_push($empty,"name");
if (empty($phone)) array_push($empty,"phone");
if (empty($email)) array_push($empty,"email");
if (empty($payment)) array_push($empty,"payment");
if (empty($gender)) array_push($empty,"gender");
if (empty($b_day) || $b_day == 'day') array_push($empty,"select_day");
if (empty($b_month) || $b_month == 'month') array_push($empty,"select_month");
if (empty($b_year) || $b_year == 'year') array_push($empty,"select_year");


  if (empty($name) || empty($phone) || empty($email) || empty($payment) || empty($gender) || empty($b_day) || empty($b_month) || empty($b_year) || ($b_day === "day") || ($b_month === "month") || ($b_year === "year")) {
    //$arr = array('status' => 'error', 'message' => 'is blank', 'fields' => implode($empty));
    $arr = array('status' => 'error', 'message' => 'is blank', 'fields' => $empty);
    echo json_encode($arr);
    //echo json_encode($empty);
    exit;
  } else {

// PHPMailer
    $mail = new PHPMailer;
    $mail->From = $email;
    $mail->FromName = $name;
  if ($recipient !== $from) {
    $mail->AddAddress($recipient);}
    $mail->AddAddress($from);
    $mail->Subject = 'New Form Submit on http://paid-funeral.co.uk';
    $mail->Body = "Name: $name\r\n\r\n".
                  "Phone Number: $phone\r\n\r\n".
                  "Email: $email\r\n\r\n".
                  "Payment type: $payment\r\n\r\n".
                  "Gender: $gender\r\n\r\n".
                  "Date of birth:\r\n\r\n".
                  "\t\t Day: \t$b_day\r\n" .
                  "\t\t Month:\t$b_month\r\n" .
                  "\t\t Year: \t$b_year\r\n";

// Send the message, check for errors
    if (!$mail->send()) {
      $arr = array('status'   => 'error',
                   'message'  => 'error',
                   'name'     => $name,
                   'phone'    => $phone,
                   'email'    => $email,
                   'payment'  => $payment,
                   'gender'   => $gender,
                   'day'      => $b_day,
                   'month'    => $b_month,
                   'year'     => $b_year,
                   'errorinfo' => $mail->ErrorInfo
                 );
      echo json_encode($arr);
      exit;
    } else {
      $arr = array('status' => 'ok', 'message' => 'complite');
      echo json_encode($arr);
      exit;
    }
  }
