<?php

declare(strict_types=1);

require(__DIR__ . '/../../common/autoload.php');

use App\Exception\LoginFailed;
use App\Helper\ValidatorHelper;
use App\Helper\LoginHelper;

$title = 'Login';

$errors = [];
if (false === empty($_POST) && isset($_POST['submit'])) {
    $errors = ValidatorHelper::validateLogin($_POST);

    if (true === empty($errors)) {
        $login = new LoginHelper();
        try {
            $user = $login->attemptLogin($_POST['email'], $_POST['password']);
            session_start();
            $_SESSION['user'] = $user->id;
            header('Location: /');
        } catch (LoginFailed $e) {
            $errors['general'] = 'Sorry, the email and/or password is incorrect';
        }
    }
}

?>

<?php require(__DIR__ . '/../../src/template/header.php'); ?>

<div class="login wrapper narrow">
    <div class="paper">
        <h1 class="centered">Login</h1>

        <?php if (false === empty($errors)): ?>
            <div class="message error">

                <?php foreach ($errors as $error): ?>
                    <span><?php echo $error; ?></span>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="row">
                <label for="email">Email address</label>
                <input type="text" id="email" name="email" placeholder="johndoe@email.com"~<?php if(false === empty($_POST['email'])) : ?> value="<?php echo htmlspecialchars($_POST['email']); ?>"<?php endif; ?>>
            </div>
            
            <div class="row">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="row">
                <input type="submit" name="submit" value="Login">
            </div>
        </form>

        <div class="additional">
            <p>Don't have an account?<br> You can <a href="/register/">register here</a>.</p>
        </div>
    </div>
</div>

<?php require(__DIR__ . '/../../src/template/footer.php'); ?>