<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
    function connect() {
        $conn = new mysqli("127.0.0.1","root","","moviewebdatabase");
        if($conn->connect_error) {
            die('Connect error:'. $conn->connect_error);
        }
        return $conn;
    }

    function login($user, $pass) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }

        $result = $stm->get_result();
        if ($result->num_rows === 0) {
            return array('code' => 1, 'error' => 'User does not exists');
        }
        $data = $result->fetch_assoc();
        
        $hashed_password = $data['password'];
        
        if (!password_verify($pass, $hashed_password)) {
            return array('code' => 2, 'error' => 'Invalid password');
        }
        else if ($data['activated'] == 0) {
            return array('code' => 3, 'error' => 'This account is not activated');
        }
        else return array('code' => 0, 'error' => '', 'data' => $data);
    }

    function is_email_exists($email) {
        $sql = "SELECT username FROM user WHERE email = ?";
        $conn = connect();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);

        if (!$stm->execute()) {
            die('Query error:'. $stm->error);
        }

        $result = $stm->get_result();
        return $result->num_rows > 0;
    }

    function register($user, $pass, $first, $last, $email) {

        if (is_email_exists($email)) {
            return array('code' => 1, 'error' => 'Email exists');
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0, 1000);
        $token = md5($user . '+' . $rand);

        $sql = "INSERT INTO user (username,
        password,email,firstname,lastname,activate_token) 
        VALUES(?, ?, ?, ?, ?, ?)";

        $conn = connect();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssss', $user, $hash, $email, $first, $last,$token);

        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Cannot execute command');
        }
        $name = $first . " " . $last;
        sendActivationEmail($email, $token, $name);

        return array('code' => 0, 'error' => 'Create account successful');
    }

    function sendActivationEmail($email, $token, $recipient) {
        
        

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'gtvprimeofficial@gmail.com';                     //SMTP username
            $mail->Password   = 'hienrypckkjfxezb';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('gtvprimeofficial@gmail.com', 'Admin');
            $mail->addAddress($email, $recipient);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verify your account';
            $mail->Body    = "Click <a href='http://localhost/movies-web-project/activate.php?email=$email&token=$token'>here</a> to verify";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
 
    }

    function activeAccount($email, $token) {
        $sql = 'SELECT username FROM user WHERE email = ? AND activate_token = ? AND activated = 0';

        $conn = connect();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $token);

        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        $result = $stm->get_result();
        if ($result->num_rows == 0) {
            return array('code' => 2, 'error' => 'email address or token not found');
        }

        $sql = "UPDATE user SET activated = 1, activate_token = '' WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);

        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Can not execute command');
        }
        return array('code' => 0, 'message' => 'Account activated');

    }
?>