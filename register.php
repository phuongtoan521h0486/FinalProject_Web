<?php
    require_once('db.php');
    $error = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $user = '';
    $pass = '';
    $pass_confirm = '';

    if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email'])
    && isset($_POST['user']) && isset($_POST['pswd']) && isset($_POST['re-pswd']))
    {
        $first_name = $_POST['first'];
        $last_name = $_POST['last'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $pass = $_POST['pswd'];
        $pass_confirm = $_POST['re-pswd'];

        if (empty($first_name)) {
            $error = 'Please enter your first name';
        }
        else if (empty($last_name)) {
            $error = 'Please enter your last name';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pass)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pass) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else if (empty($pass_confirm)) {
            $error = 'Please cofirm your password';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Password does not match';
        }
        else {
            // register a new account
            $result = register($user, $pass, $first_name, $last_name, $email);
            if ($result['code'] == 0) {
                header('Location: activate.php');
                die('Đăng kí thành công');
            }
            else if ($result['code'] == 1) {
                $error = 'This email is already exists';
            }
            else {
                $error = 'An error occured. Please try agian later';
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
                <div class="col-lg-6 side-image">
                    <div class="text">
                        <a class="btn btn-danger" href="login.php">Sign in now</a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 left">
                    <div class="input-box">
                        <header>Register</header>

                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold" for="firstname">First name:</label>
                                    <input value="<?= $first_name ?>" name="first" class="form-control input-field"  class="form-control" type="text" placeholder="First name" id="firstname">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold" for="lastname">Last name:</label>
                                    <input value="<?= $last_name ?>" name="last" class="form-control input-field" class="form-control" type="text" placeholder="Last name" id="lastname">
                                    <div class="invalid-tooltip">Last name is required</div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold" for="user">Username:</label>
                              <input value="<?= $user ?>" type ="text" class="form-control input-field" id="username" placeholder="Enter username" name="user">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold" for="email">Email:</label>
                              <input value="<?= $email ?>" type ="text" class="form-control input-field" id="email" placeholder="Enter email" name="email">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold" for="pwd">Password:</label>
                              <input type="password" class="form-control input-field" id="pwd" placeholder="Enter password" name="pswd">
                            </div>
                            <div class="form-group">
                              <label class="font-weight-bold" for="pwd">Confirm password:</label>
                              <input type="password" class="form-control input-field" id="re-pwd" placeholder="Re-type password" name="re-pswd">
                            </div>
                            <!-- <div class="form-group form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Remember me
                              </label>
                            </div> -->

                            <div class="signin d-flex justify-content-center">
                                <?php
                                if (!empty($error)) {
                                    echo "<div class='alert alert-danger'>$error</div>";
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                                <p class="register">Already have an account? <a href="login.php">Sign in</a></p>
                            </div>
                            

                        </form>
                    </div>
                    
                </div>     
            </div>
        </div>
    </div>

</body>
</html>