<?php
class LoginForm {
    private $mysqli;
    private $username;
    private $password;
    private $username_err;
    private $password_err;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->username = $this->password = "";
        $this->username_err = $this->password_err = "";
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->validateFormData();
            if ($this->isFormDataValid()) {
                $this->authenticateUser();

                if (!empty($_POST['remember_me'])) {
                    $this->setRememberMeCookie();
                }
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (!isset($_SESSION["loggedin"]) && isset($_COOKIE['remember_me'])) {
                $this->handleRememberMe();
            }
        }
    }

    private function setRememberMeCookie() {
        $cookie_username = base64_encode($this->username);
        $cookie_password = base64_encode($this->password);
        setcookie('remember_me', $cookie_username . '|' . $cookie_password, time() + (86400 * 30), "/"); 
    }

    private function handleRememberMe() {
        $remember_data = explode('|', base64_decode($_COOKIE['remember_me']));
        $username = base64_decode($remember_data[0]);
        $password = base64_decode($remember_data[1]);

        $this->username = $username;
        $this->password = $password;
        $this->authenticateUser();
    }

    private function validateFormData() {
        if (empty(trim($_POST["username"]))) {
            $this->username_err = "Please enter your username.";
        } else {
            $this->username = trim($_POST["username"]);
        }

        if (empty(trim($_POST["password"]))) {
            $this->password_err = "Please enter your password.";
        } else {
            $this->password = trim($_POST["password"]);
        }
    }

    private function isFormDataValid() {
        return empty($this->username_err) && empty($this->password_err);
    }

    private function authenticateUser() {
        $sql = "SELECT user_id, username, email, password FROM user WHERE username = ?";
    
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param("s", $this->username);
    
            if ($stmt->execute()) {
                $stmt->store_result();
    
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($user_id, $username, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($this->password, $hashed_password)) {
                            session_start();
    
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            header("location: index.php");
                        } else {
                            $this->password_err = "The password you entered is not valid.";
                        }
                    }
                } else {
                    $this->username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
    
            $stmt->close();
        }
    }

    public function getUsernameError() {
        return $this->username_err;
    }

    public function getPasswordError() {
        return $this->password_err;
    }

    public function getUsername() {
        return $this->username;
    }
}
?>