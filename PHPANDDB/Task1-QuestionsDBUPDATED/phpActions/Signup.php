<?php

class Signup
{
    private $error = "";


    public function evaluate($data)
    { //Server side validation

        foreach ($data as $key => $value) {
            if (empty($data)) {
                $this->error .= $key . "can't be empty!\n<br\>";
            }

            if ($key == 'signup-email') {
                if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) {
                    $this->error .= "invalid email address!<br>";
                }
            }

            if ($key == "signup-username") {
                //check if entered valuse by the user is numbers
                if (is_numeric($value)) {
                    $this->error .= "User Name can't be a number!<br\>";
                }
            }
        }

        if ($data["signup-password"] !== $data["signup-confirm-password"]) {
            $this->error .= "\nPassword does not match\n<br\>";
        }
        try {
            if ($this->error == "") {
                //No error create user
                return $this->createUser($_POST);
            } else {
                return $this->error;
            }
        } catch (Exception $e) {
            $this->error .= "Error accord: " . $e->getMessage();
            throw new Exception($this->error, 1);

        }
    }

    private function createUser($data)
    {
        $userName = $data["signup-username"];
        $userEmail = $data["signup-email"];
        $userPassword = $data["signup-password"];
        $encryptedPassword = md5($userPassword);
        $query = "INSERT INTO users (username,email,password) VALUES (?,?,?)";
        try {
            $conn = new Database();
            $conn->write($query, [$userName, $userEmail, $encryptedPassword]);

        } catch (Exception $e) {
            //If Email already exists
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $err = "The question already exists in the database. Thanks for trying";
                throw new Exception($err, 1);
            } else {
                // return "An error occurred: " . $e->getMessage();
                throw new Exception("Error Processing Request: " . $e->getMessage(), 1);
            }
        }
    }
}