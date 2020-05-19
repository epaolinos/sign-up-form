<?php
include ("Sanitizer.php");

class ProfileEnter
{
    public $login;
    public $password;
    public $link;

    /**
     * ProfileEnter constructor.
     * Gets two-elements form (e-mail, password) and link info.
     */
    function __construct($form, $link) {
        $sanitizer = new Sanitizer($form);
        $sanForm = $sanitizer->getLogInSanitized();
        $this->login = $sanForm[0];
        $this->password = $sanForm[1];
        $this->link = $link;
    }

    /**
     * Returns true if there is a profile with given e-mail
     */
    function loginExists() {
        $useQuery = "USE users;";
        $this->link->query($useQuery);
        // Prevents 'Commands out of sync' error here
        $this->clearStoredResults();
        $selectQuery = "SELECT 1 from profiles WHERE email = '{$this->login}';";
        $result = $this->link->query($selectQuery) or trigger_error($this->link->error."[$selectQuery]");
        return ($result->num_rows > 0);
    }

    /**
     * Returns true if there is a profile with given e-mail and password.
     */
    function passwordCorrect() {
        $result = $this->getFromDatabase();
        return (!is_null($result));
    }

    /**
     * If e-mail and password are correct sends data to the profile page.
     */
    function profilePage() {
        if ($this->passwordCorrect()) {
            $id = $this->getFromDatabase()[0];
            // Relocates there so that page doesn't require sending form on reloading or changing language
            header("Location: relocation.php?id=${id}&&email={$this->login}");
            exit();
        } else {
            die ("Wrong e-mail or password");
        }
    }

    /**
     * Returns id of a profile with given e-mail and password.
     */
    function getFromDatabase() {
        $useQuery = "USE users;";
        $this->link->query($useQuery);
        $getQuery = "SELECT id from profiles WHERE email = '{$this->login}' AND password = '{$this->password}';";
        $this->clearStoredResults();
        $result = $this->link->query($getQuery) or trigger_error($this->link->error."[$getQuery]");
        return $result->fetch_array(MYSQLI_NUM);
    }

    /**
     * Clears query results and prevents 'Commands out of sync' error.
     */
    function clearStoredResults(){
        do {
            if ($res = $this->link->store_result()) {
                $res->free();
            }
        } while ($this->link->more_results() && $this->link->next_result());
    }
}