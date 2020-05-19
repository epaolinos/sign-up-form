<?php
include ("PasswordChecker.php");

class Sanitizer
{
    public $fname;
    public $lname;
    public $email;
    public $password;
    // we use strlen($passwordConf) to define how to check password so it must be initialized here
    public $passwordConf = "";

    /**
     * Sanitizer constructor.
     * Sanitizer can receive parameters both for Sign Up and Log In so
     * the constructor chooses how to treat data.
     */
    function __construct($form) {
        if (sizeof($form) > 2) {
            $this->fname = $form[0];
            $this->lname = $form[1];
            $this->email = $form[2];
            $this->password = $form[3];
            $this->passwordConf = $form[4];
        } else {
            $this->email = $form[0];
            $this->password = $form[1];
        }
    }

    /**
     * Evaluates all procedures for Sign Up form and returns sanitized data.
     */
    function getSignUpSanitized() {
        $this->sanitizeName();
        $this->sanitizeEmail();
        $this->sanitizePassword();
        return array($this->fname, $this->lname, $this->email, $this->password);
    }

    /**
     * Evaluates all procedures for Log In form and returns sanitized data.
     */
    function getLogInSanitized() {
        $this->sanitizeEmail();
        $this->sanitizePassword();
        return array($this->email, $this->password);
    }

    /**
     * Sanitizes the first and the last name checking the pattern and deleting all the senseless spaces.
     */
    function sanitizeName() {
        $pattern = "/[0-9`!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?~]/";
        if (!preg_match($pattern, $this->fname) && !preg_match($pattern, $this->lname)) {
            $this->fname = trim($this->fname);
            $this->lname = trim($this->lname);
        } else {
            die("Error. Check your form data");
        }
    }

    /**
     * Sanitizes e-mail checking the pattern and evaluating built-in PHP sanitizing
     */
    function sanitizeEmail() {
        $pattern = "/^[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}$/i";
        if (preg_match($pattern, $this->email)) {
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        } else {
            die("Error. Check your form data");
        }
    }

    /**
     * Sanitizes password checking it with PasswordChecker object and deletes html characters
     * (even if they cannot really be there after checking).
     */
    function sanitizePassword() {
        // If there is a password confirmation we put it to the checker, too
        $passCheckerInput = (strlen($this->passwordConf) > 0) ?
            array($this->password, $this->passwordConf) : $this->password;
        $passwordChecker = new PasswordChecker($passCheckerInput);
        if ($passwordChecker->getRelevance()) {
            $this->password = htmlspecialchars($this->password);
        } else {
            die("Error. Check your form data");
        }
    }
}