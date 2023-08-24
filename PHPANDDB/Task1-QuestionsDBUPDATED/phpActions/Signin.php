<?php

class SignIn
{

    private $error = "";

    public function validateLogin($data)
    {
        $useremail = $data['email'];
        $password = $data['password'];
        $query = "SELECT * FROM users WHERE email= ? AND password = ? LIMIT 1";

        if (empty($useremail) || empty($password)) {
            $this->error .= "Please fill in all required data";
        }
        if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $useremail)) {
            $this->error .= "Invalid email";
        }
        if ($this->error != "") {
            return $this->error;
        }
        try {
            $conn = new Database();
            //md5:128-bit hash value.
            $encryptedPass = md5($password);
            $userData = $conn->read($query, [$useremail, $encryptedPass]);
            if ($userData) { //user exists
                $row = $userData[0];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
            } else {
                $this->error .= "Invalid email or password";
            }
            return $this->error;
        } catch (Exception $e) {
            throw new Exception("Couldn't login Try again later", 1);
        }

    }

    public function check_login($data)
    {
        if (!empty($data) && is_numeric($data)) {
            $query = "SELECT * FROM users WHERE id = '$data' limit 1";
            try {
                $conn = new Database();
                $userData = $conn->read($query);
                if ($userData) {
                    return $userData[0];
                } else {
                    header("Location: login.php?Login to enter");
                    die;
                }
            } catch (Exception $e) {
                throw new Exception("Error Processing login Request", 1);
            }
        } else {
            unset($_SESSION['user_id']);
            $this->error .= "Please login";
        }
        return $this->error;
    }
}