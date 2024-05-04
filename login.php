<?php

session_start();

include 'header.php';
include 'dbinit.php';
include './controllers/LoginForm.php';

$loginForm = new LoginForm($mysqli);

$loginForm->handleLogin();

?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center">
        <div class="card p-4 lgCard border-0">
            <h2 class="mb-4 text-center lgTitle">Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-outline mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control w-100" id="username" name="username"
                        value="<?php echo htmlspecialchars($loginForm->getUsername()); ?>">
                    <span class="help-block text-danger"><?php echo htmlspecialchars($loginForm->getUsernameError()); ?></span>
                </div>
                <div class="form-outline mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control w-100" id="password" name="password">
                    <span class="help-block text-danger"><?php echo htmlspecialchars($loginForm->getPasswordError()); ?></span>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                        <label class="form-check-label" for="remember_me">Remember Me</label>
                    </div>
                    <p class="link-margin">Not registered yet?<a href="register.php" class="fw-bold"> Register now</a></p>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary align-self-center px-4">Login</button>
                </div>
            </form>
        </div>
        </div>
        <div class="col-md-6 justify-content-end d-flex">
            <img src="./images/draw2.png" class="img-fluid login-image" alt="Right Image">
        </div>
    </div>
</div>
