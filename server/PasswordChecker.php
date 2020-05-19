<?php

class PasswordChecker
{
    public $password;
    // We use strlen($passwordConf) to define how to check password so it must be initialized here
    public $passwordConf = "";

    /**
     * PasswordChecker constructor.
     * Using PasswordChecker we can check both a password-confirmation pair
     * and a password alone so the constructor chooses how to treat the parameter.
     */
    function __construct($password) {
        if (is_array($password)) {
            $this->password = $password[0];
            $this->passwordConf = $password[1];
        } else {
            $this->password = $password;
        }
    }

    /**
     * Returns the result of all the checking activity.
     */
    function getRelevance() {
        return $this->isLongEnough() && $this->rightSymbols() && $this->confirmedRight();
    }

    /**
     * If there is a password confirmation it compares it to the password,
     * otherwise it does nothing.
     */
    function confirmedRight() {
        if (strlen($this->passwordConf) > 0) {
            return strcmp($this->password, $this->passwordConf) == 0;
        } else {
            return true;
        }
    }

    /**
     * Checks if password is longer then 8 symbols.
     */
    function isLongEnough() {
        return (strlen($this->password) >= 8);
    }

    /**
     * Checks if password has numbers, uppercase, lowercase, special symbols, and nothing more.
     */
    function rightSymbols() {
        return ((preg_match('/^[a-zA-Z0-9!@#$%^&*()\[\]_\-+\/]+$/', $this->password) > 0) &&
            (preg_match('/\\d/', $this->password) > 0) &&
            (preg_match('/[A-Z]/', $this->password) > 0) &&
            (preg_match('/[a-z]/', $this->password) > 0) &&
            (preg_match('/[\^?!@#%&\[\]()\-+\/\\\*$._\s]/', $this->password) > 0));
    }
}