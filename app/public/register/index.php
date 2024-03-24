<?php

declare(strict_types=1);

require(__DIR__ . '/../../common/autoload.php');

use App\Exception\EmailAlreadyExists;
use App\Helper\ValidatorHelper;
use App\Helper\RegisterHelper;

$title = 'Register';

$errors = [];
if (false === empty($_POST) && isset($_POST['submit'])) {
    $errors = ValidatorHelper::validateRegister($_POST);

    if (true === empty($errors)) {
        $register = new RegisterHelper();
        try {
            $user = $register->registerUser($_POST['email'], $_POST['password']);
            session_start();
            $_SESSION['user'] = $user->id;
            header('Location: /');
        } catch (EmailAlreadyExists $e) {
            $errors['email'] = 'Sorry, this email is already in use';
        }
    }
}

?>

<?php require(__DIR__ . '/../../src/template/header.php'); ?>

<div class="register wrapper narrow">
    <div class="paper">
        <h1 class="centered">Register</h1>

        <?php if (false === empty($errors)): ?>
            <div class="message error">

            <?php foreach ($errors as $error): ?>
                <span><?php echo $error; ?></span>
            <?php endforeach; ?>

            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="row<?php if (true === isset($errors['email'])) : ?> error<?php endif; ?>">
                <label for="email">Email address</label>
                <input type="text" id="email" name="email" placeholder="johndoe@email.com"~<?php if(false === empty($_POST['email'])) : ?> value="<?php echo htmlspecialchars($_POST['email']); ?>"<?php endif; ?>>
            </div>
            
            <div class="row<?php if (true === isset($errors['password'])) : ?> error<?php endif; ?>">
                <label for="password">Password <span class="note">10 - 50 characters<span></label>
                <input type="password" id="password" name="password">
            </div>

            <div class="row">
                <input type="submit" name="submit" value="Register">
            </div>
        </form>
    </div>
</div>

<?php require(__DIR__ . '/../../src/template/footer.php'); ?>