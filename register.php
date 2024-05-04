<?php

include 'dbinit.php';
include 'header.php';
include './controllers/RegisterForm.php';

$registerForm = new RegisterForm($mysqli);

$registerForm->handleRegistration();

?>

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 justify-content-center">
            <img src="./images/draw1.png" class="img-fluid register-image" alt="Left Image">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <div class="card p-4 lgCard border-0">
                <h2 class="mb-4 text-center text-black lgTitle">Register</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-outline mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?php echo htmlspecialchars($registerForm->getUsername()); ?>">
                        <span class="help-block text-danger"><?php echo htmlspecialchars($registerForm->getUsernameError()); ?></span>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($registerForm->getEmail()); ?>">
                        <span class="help-block text-danger"><?php echo htmlspecialchars($registerForm->getEmailError()); ?></span>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="<?php echo htmlspecialchars($registerForm->getPassword()); ?>">
                        <span class="help-block text-danger"><?php echo htmlspecialchars($registerForm->getPasswordError()); ?></span>
                    </div>
                    <div class="form-outline mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            value="<?php echo htmlspecialchars($registerForm->getConfirmPassword()); ?>">
                        <span class="help-block text-danger"><?php echo htmlspecialchars($registerForm->getConfirmPasswordError()); ?></span>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary align-self-center px-4">Register</button>
                    </div>
                    <div class="text-center mt-3">
                        <p>Already a user?<a href="login.php" class="fw-bold"> Login now</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

