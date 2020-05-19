<?php
include ("ProfileEnter.php");

class ProfileMaker
{
    public $link;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $pic;
    public $enter;

    /**
     * ProfileMaker constructor.
     * Gets Sign In form and initialize class variables with sanitized data.
     */
    function __construct($form, $link) {
        $sanitizer = new Sanitizer($form);
        $sanForm = $sanitizer->getSignUpSanitized();
        $this->fname = $sanForm[0];
        $this->lname = $sanForm[1];
        $this->email = $sanForm[2];
        $this->password = $sanForm[3];
        $this->pic = $form[5];
        $this->link = $link;
        $newForm = array($this->email, $this->password);
        $this->enter = new ProfileEnter($newForm, $this->link);
    }

    /**
     * If e-mail is new adds it to the DB and opens the profile page
     */
    function makeProfile() {
        if (!$this->enter->loginExists()) {
            $this->addToDatabase();
            $this->goToProfile();
        } else {
            die("A profile with this e-mail already exists");
        }
    }

    /**
     * Adds the form to the DB
     */
    function addToDatabase() {
        $useQuery = "USE users;";
        $this->link->query($useQuery);
        $insertQuery = "INSERT INTO profiles (fname, lname, email, password, pic) 
                        VALUES ('{$this->fname}', '{$this->lname}', '{$this->email}', '{$this->password}',
                               '{$this->pic}');";
        $result = $this->link->query($insertQuery) or trigger_error($this->link->error."[$insertQuery]");
    }

    /**
     * After adding to DB loginExists() must be true so it uses ProfileEnter functionality
     */
    function goToProfile() {
        if ($this->enter->loginExists()) {
            $this->enter->profilePage();
        } else {
            die("We had some problem in registration, try again");
        }
    }
}