<html>
    <?php 
        include_once 'database.php';
        require_once 'signup-form.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://kit.fontawesome.com/74d37a292d.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script-login.js"></script>
    </head>
    <body class="login-body">
        <div id="login-form" class="login-container">
            <form action="login.php" id="login-form" method="POST">
                <div class="login-field">
                    <div class="error-login"><p id="error-login-message"><?php echo $errorLogin; ?></p></div>
                    <label for="login-username"><i class="login-icon fa-solid fa-user"></i></label>
                    <input type="text" id="login-username" name="username" class="login-input" placeholder="Username" required>
                </div>
                <div class="login-field">
                    <label for="login-password"><i class="login-icon fa-solid fa-lock"></i></label>
                    <input type="password" id="login-password" name="password" class="login-input" placeholder="Password" required>
                </div>
                <div class="login-field">
                    <input class="login-submit-btn" type="submit" name="login-btn" value="LOGIN">
                </div>
            </form>
            <p class="center-text">New User? <a id="login-hl" class="login-hl-nu">SIGN UP</a></p>
        </div>
        <div id="signup-form" class="login-container">
            <form action="login.php" id="signup-form" method="POST" novalidate>
                <?php if(count($error) > 0):?>
                    <div class="error-login">
                        <?php foreach($error as $errors):?>
                            <p><?php
                                echo $errors;?>
                            </p><?php
                        endforeach;?>
                    </div>
                <?php endif;?>
                <div class="login-field">
                    <label for="signup-username">Select Username</label>
                    <input type="text" id="signup-username" name="username" class="login-input signup-input" placeholder="Username" required>
                </div>
                <div class="login-field">
                    <label for="signup-email">Your Email Address</label>
                    <input type="email" id="signup-email" name="email" class="login-input signup-input" placeholder="Email" required>
                </div>
                <div class="login-field">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" name="password" class="login-input signup-input" placeholder="Password" required>
                </div>
                <div class="login-field">
                    <label for="signup-password-check">Repeat Password</label>
                    <input type="password" id="signup-password-check" name="repeat_password" class="login-input signup-input" placeholder="Repeat Password" required>
                </div>
                <div class="login-field">
                    <input class="login-submit-btn" type="submit" name="signup-btn" value="SIGNUP">
                </div>
            </form>
            <p class="center-text">Already have an Account? <a id="signup-hl" class="login-hl-nu">LOGIN</a></p>
        </div>
    </body> 
    <script>
        var activeField = <?php echo $active; ?>;
        if (activeField === 0){
            $('#signup-form').hide();
        }
        else {
            $('#login-form').hide();
        }
    </script>
</html>