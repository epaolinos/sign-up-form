# Sign Up form
Hello, my name is Pavel Egizaryan, and this is a sign up form made as my personal project.

## Client side
On the client side we have three pages with simple design: `login.html`, `signup.html` and `profile.html`.
The default language of all the pages is English, but it can be simply changed to Russian.

There is only one `style.css` used for all the pages.
We also have `translator.js` that changes language and `formvalidator.js` that checks the form information sent by user.
`img` folder contains design images for the pages.

## Server side
On the server side there are three main files: `loginevaluation.php` receives data from the Log In page and sends it to 
the sanitizing and to the Profile page making, `signupevaluation.php` makes all the same with the Sign Up page, but is 
more difficult because of more data in the Sign Up form, `relocation.php` gets the final data from MySQL and makes the
Profile page.

Other files here are classes responsible for sanitizing and checking data and interacting with the database: 
`ProfileMaker.php`, `Sanitizer.php`, `PasswordChecker.php`, `ProfileEnter.php`.

`userpics` folder contains images sent by users and the `standard.jpg` used for those who didn't send a photo. 


## Database
Database has an only table with a very simple structure:

ID | First name | Last name | E-mail | Password | Picture name
---|------------|-----------|--------|----------|--------
1|John|Johnson|john@johnson.com|H1kz_Vc)|standard.jpg

`dump.sql` contains MySQL dump you can use to try some existing profiles made by the author.

