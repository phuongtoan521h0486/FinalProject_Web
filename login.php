<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    
    $error = '';

    $user = '';
    $pass = '';
    require_once('db.php');
    if (isset($_POST['user']) && isset($_POST['pswd'])) {
        $user = $_POST['user'];
        $pass = $_POST['pswd'];

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else {
            $result = login($user, $pass);
            if ($result['code'] == 0) {
                $data = $result['data'];
                $_SESSION['user'] = $user;
                $_SESSION['name'] = $data['firstname'] . ' ' . $data['lastname'];

                header('Location: index.php');
                exit();
            }
            else {
                $error = $result['error'];
            }
        }
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>

</head>
<body>
    <div class="wrapper">
        <img src="image/logoGTVPrimefinal.png" alt="">
        <div class="container main">
            <div class="row">
                <div class="col-lg-6 col-sm-12 left">
                    <div class="input-box">
                        <header>Login</header>

                        <form action="" method="post">
                            <div class="form-group">
                              <label class="font-weight-bold" for="email">Username:</label>
                              <input type ="text" class="form-control input-field" id="username" placeholder="Enter username" name="user">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold" for="pwd">Password:</label>
                              <input type="password" class="form-control input-field" id="pwd" placeholder="Enter password" name="pswd">
                            </div>
                            <div class="form-group form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Remember me
                              </label>
                            </div>

                            <div class="signin d-flex justify-content-center">
                            <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                             ?>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <p class="register">Not have an account? <a href="register.php">Sign up</a></p>
                            </div>
                            

                        </form>
                    </div>
                </div>

                <div class="col-lg-6 side-image">
                    <div class="text">
                        <a class="btn btn-danger" href="register.php">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>