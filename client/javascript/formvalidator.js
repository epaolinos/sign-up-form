import(isEnglish());

/**
 * Validation for sign up form
 */
function validateSignUpForm() {
    let fname = document.forms["signup-form"]["first_name"].value;
    let lname = document.forms["signup-form"]["last_name"].value;
    let email = document.forms["signup-form"]["email"].value;
    let password = [document.forms["signup-form"]["password"].value,
        document.forms["signup-form"]["password_confirm"].value];
    return (nameIsValid(fname) && nameIsValid(lname) && emailIsValid(email)
        && newPasswordIsValid(password));
}

/**
 * Validation for log in form
 */
function validateLogInForm() {
    let emailValid = emailIsValid(document.forms["login-form"]["email"].value);
    let passwordValid = passwordIsValid(document.forms["login-form"]["password"].value)
    return emailValid && passwordValid;
}

/**
 * Works for first names and last names in sign up forms, doesn't allow special symbols
 */
function nameIsValid(name) {
    let nameFormat = /[0-9`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    let nameHint = document.getElementById("incorrect-name");
    if (nameFormat.test(name)) {
        let message = (isEnglish()) ?
            "• Special symbols or numbers in name" : "• Спецсимволы или цифры в имени";
        nameHint.innerHTML = message;
        nameHint.style.display = 'block';
        return false;
    } else {
        if (nameHint.style.display === 'block') nameHint.style.display = 'none';
        return true;
    }
}

/**
 * Checks the format of e-mail in sign up and log in forms,
 * shows hint and hides it when no more needed
 */
function emailIsValid(email) {
    let emailFormat = /^[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}$/i;
    let emailHint = document.getElementById("incorrect-email");
    if (!emailFormat.test(email)) {
        let message = (isEnglish()) ?
            "• Incorrect e-mail" : "• Некорректный e-mail";
        emailHint.innerHTML = message;
        emailHint.style.display = 'block'
        return false;
    } else {
        if (emailHint.style.display === 'block') emailHint.style.display = 'none';
        return true;
    }
}

/**
 * Checks password and its confirmation in sign up forms
 */
function newPasswordIsValid(passwordConf) {
    let confirmed = passwordConfirmed(passwordConf);
    let valid = passwordIsValid(passwordConf[0]);
    return confirmed && valid;
}

/**
 * Checks equality of password and its confirmation for sign up forms,
 * shows hint if it doesn't match and hides it if no more needed
 */
function passwordConfirmed(passwordArray) {
    let confirmationHint = document.getElementById("confirmation-fail");
    if (passwordArray[0] !== passwordArray[1]) {
        let message = (isEnglish()) ?
            "• Check confirmation" : "• Проверьте подтверждение";
        confirmationHint.innerHTML = message;
        confirmationHint.style.display = 'block';
        return false;
    } else {
        if (confirmationHint.style.display === 'block') confirmationHint.style.display = 'none';
        return true;
    }
}

/**
 * Checks correct password symbols for log in and sign up forms,
 * shows hints for problems and hides them if no more needed
 */
function passwordIsValid(password) {
    let passwordFormat = /^[a-zA-Z0-9!@#$%^&*()[\]_\-\+\/\\]+$/;
    let incorrSymbHint = document.getElementById("incorrect-sym");
    let upperCase = /[A-Z]/;
    let upperCaseHint = document.getElementById("uppercase");
    let shortPassHint = document.getElementById("short-pass");
    let lowerCase = /[a-z]/;
    let lowerCaseHint = document.getElementById("lowercase");
    let numbers = /[0-9]/;
    let numbersHint = document.getElementById("numbers");
    let specialSymbols = /[!@#$%^&*()[\]_\-\+\/\\]/;
    let specialSymbHint = document.getElementById("special-sym");
    if (!passwordFormat.test(password)) {
        let message = (isEnglish()) ?
            "• Incorrect symbols in password" : "• Некорректные символы в пароле";
        incorrSymbHint.innerHTML = message;
        incorrSymbHint.style.display = 'block';
    } else {
        if (incorrSymbHint.style.display === 'block') incorrSymbHint.style.display = 'none';
    }
    if (password.length < 8) {
        let message = (isEnglish()) ?
            "• Password is too short" : "• Пароль слишком короткий";
        shortPassHint.innerHTML = message;
        shortPassHint.style.display = 'block';
    } else {
        if (shortPassHint.style.display === 'block') shortPassHint.style.display = 'none';
    }
    if (!upperCase.test(password)) {
        let message = (isEnglish()) ?
            "• No uppercase in password" : "• В пароле нет заглавных букв";
        upperCaseHint.innerHTML = message;
        upperCaseHint.style.display = 'block';
    } else {
        if (upperCaseHint.style.display === 'block') upperCaseHint.style.display = 'none';
    }
    if (!lowerCase.test(password)) {
        let message = (isEnglish()) ?
            "• No lowercase in password" : "• В пароле нет строчных букв";
        lowerCaseHint.innerHTML = message;
        lowerCaseHint.style.display = 'block';
    } else {
        if (lowerCaseHint.style.display === 'block') lowerCaseHint.style.display = 'none';
    }
    if (!numbers.test(password)) {
        let message = (isEnglish()) ?
            "• No numbers in password" : "• В пароле нет цифр";
        numbersHint.innerHTML = message;
        numbersHint.style.display = 'block';
    } else {
        if (numbersHint.style.display === 'block') numbersHint.style.display = 'none';
    }
    if (!specialSymbols.test(password)) {
        let message = (isEnglish()) ?
            "• No special symbols in password" : "• В пароле нет спецсимволов";
        specialSymbHint.innerHTML = message;
        specialSymbHint.style.display = 'block';
    } else {
        if (specialSymbHint.style.display === 'block') specialSymbHint.style.display = 'none';
    }
    return (passwordFormat.test(password) && !password.length < 8 && upperCase.test(password) &&
        lowerCase.test(password) && numbers.test(password) && specialSymbols.test(password));
}