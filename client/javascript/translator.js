/**
 * Loading the page we set all the strings that depend of the language
 */
window.onload = function(){
    langSettings();
}

/**
 * Function called by the language change button that puts
 * the language information to the sessionStorage and reloads the page
 */
function changeLang() {
    let newState = (!isEnglish()).toString();
    sessionStorage.setItem('english', newState);
    window.location.reload();
}

/**
 * Determines the actual language using sessionStorage
 * (English is default)
 */
function isEnglish() {
    // This return makes button properly even with the first switch
    return !(sessionStorage.getItem('english') === 'false');
}

/**
 * Contains a dictionary with the key equivalent to
 * the corresponding HTML id and arrays with English and Russian version
 */
function langSettings() {
    let siteDict = {
        'mainpage-title': ["Log in", "Вход"],
        'login-heading': ["Log in", "Войдите"],
        'email-login': ["user@example.com", "user@example.com", "Your e-mail", "Ваш e-mail"],
        'password-login': ["•••••••••••", "•••••••••••", "Your password", "Ваш пароль"],
        'login-button': ["Log in", "Войти"],
        'new-user': ["New user?", "Новый пользователь?"],
        'lang-button': ["Русский", "English"],
        'wrong-password': ["&emsp;Wrong e-mail or password", "Неверный e-mail или пароль"],
        'signup-page-title': ["Sign up", "Регистрация"],
        'signup-heading': ["Sign up", "Регистрация"],
        'fname-signin': ["First name", "Имя", "First name — required", "Имя — обязательное поле"],
        'lname-signin': ["Last name", "Фамилия", "Last name — required", "Фамилия — обязательное поле"],
        'email-signin': ["E-mail", "E-mail", "E-mail — required", "E-mail — обязательное поле"],
        'password-signin': ["Password", "Пароль",
            "Write your password (min 8 symbols), using latin UPPERCASE, lowercase, numbers (1–9) and special symbols (!@#$%^&*()[]_-+/\\)",
            "Придумайте пароль (минимум 8 символов), используя ЗАГЛАВНЫЕ и строчные латинские буквы, цифры (1–9) и специальные символы (!@#$%^&*()[]_-+/\\)"],
        'password-confirmation': ["Confirm your password", "Подтвердите пароль",
            "Confirm your password — required", "Подтвердите пароль — обязательно"],
        'pic-text': ["&emsp;&emsp;&emsp;Your photo", "&emsp;&emsp;&emsp;Ваше фото"],
        'submit-button': ["Submit", "Отправить"],
        'profile-title': ["Profile", "Профиль"],
        'hello-profile': ["Hello, ", "Здравствуйте, "],
        'fname-profile': ["First name: ", "Имя: "],
        'lname-profile': ["Last name: ", "Фамилия: "],
    }
    let lang = (isEnglish()) ? 0 : 1;

    for (let id in siteDict) {
        let element = document.getElementById(id);
        if (typeof element !== 'undefined' && element !== null) {
            // input tags need booth placeholder and title translations,
            // their arrays in siteDict have 4 elements, not 2
            if (element.tagName === 'INPUT') {
                element.placeholder = siteDict[id][lang];
                element.title = siteDict[id][lang + 2];
            } else {
                element.innerHTML = siteDict[id][lang];
            }
        }
    }
}

/**
 * Shows that the pic is loaded in an appropriate language
 * and returns to the start text if the upload is cancelled
 */
function picLoaded() {
    if (document.getElementById("fl-inp").value !== "") {
        document.getElementById("pic-text").innerHTML =
            (isEnglish()) ? "&emsp;&emsp;&emsp;Loaded" : "&emsp;&emsp;&emsp;Загружено";
    } else {
        document.getElementById("pic-text").innerHTML =
            (isEnglish()) ? "&emsp;&emsp;&emsp;Your photo" : "&emsp;&emsp;&emsp;Ваше фото";
    }
}
