<?php
class RegisterForm {
    private $username;
    private $email;
    private $password;
    private $confirm_password;
    private $username_err;
    private $email_err;
    private $password_err;
    private $confirm_password_err;
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->username = $this->email = $this->password = $this->confirm_password = "";
        $this->username_err = $this->email_err = $this->password_err = $this->confirm_password_err = "";
    }

    public function handleRegistration() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->validateFormData();
            if ($this->isFormDataValid()) {
                $this->insertUser();
            }
        }
    }

    private function validateFormData() {
        if (empty(trim($_POST["username"]))) {
            $this->username_err = "Please enter a username.";
        } else {
            $this->username = trim($_POST["username"]);
        }

        if (empty(trim($_POST["email"]))) {
            $this->email_err = "Please enter your email.";
        } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $this->email_err = "Invalid email format.";
        } else {
            $this->email = trim($_POST["email"]);
        }

        if (empty(trim($_POST["password"]))) {
            $this->password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $this->password_err = "Password must have at least 6 characters.";
        } else {
            $this->password = trim($_POST["password"]);
        }

        if (empty(trim($_POST["confirm_password"]))) {
            $this->confirm_password_err = "Please confirm password.";
        } else {
            $this->confirm_password = trim($_POST["confirm_password"]);
            if ($this->password != $this->confirm_password) {
                $this->confirm_password_err = "Password did not match.";
            }
        }
    }

    private function isFormDataValid() {
        return empty($this->username_err) && empty($this->email_err) && empty($this->password_err) && empty($this->confirm_password_err);
    }

    private function insertUser() {
        $sql_check = "SELECT * FROM user WHERE username = ? OR email = ?";
        if ($stmt_check = $this->mysqli->prepare($sql_check)) {
            $stmt_check->bind_param("ss", $this->username, $this->email);

            if ($stmt_check->execute()) {
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    $this->username_err = "This username is already taken.";
                    $this->email_err = "This email is already registered.";
                } else {
                    $sql_insert = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
                    if ($stmt_insert = $this->mysqli->prepare($sql_insert)) {
                        $param_password = password_hash($this->password, PASSWORD_DEFAULT);

                        $stmt_insert->bind_param("sss", $this->username, $this->email, $param_password);

                        if ($stmt_insert->execute()) {
                            header("location: login.php");
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                        $stmt_insert->close();
                    }
                }
                $stmt_check->close();
            }
        }
    }

    public function getUsernameError() {
        return $this->username_err;
    }

    public function getEmailError() {
        return $this->email_err;
    }

    public function getPasswordError() {
        return $this->password_err;
    }

    public function getConfirmPasswordError() {
        return $this->confirm_password_err;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getConfirmPassword() {
        return $this->confirm_password;
    }
}

?>