window.getCookie = function (name) {
    let tmpCookies = document.cookie;
    let cookieAry = tmpCookies.split(';');
    for (let cookie of cookieAry) {
        if (cookie.indexOf(name) >= 0) {
            let value = cookie.split('=')[1].trim();
            return value;
        }
    }
    return null;
}

window.setCookie = function (name, value, path = '/') {
    document.cookie = name + '=' + value + '; path=' + path;
}

window.deleteCookie = function (name, path = '/') {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=' + path;
}

window.getUrlParameter = function (parameter) {
    let queryString = window.location.search;
    let urlParams = new URLSearchParams(queryString);
    return urlParams.get(parameter);
}

window.followUrl = function (url) {
    if (!url.startsWith("http")) {
        url = "https://" + url;
    }
    window.open(url, "_blank");
}

window.copyToClipboard = function (text) {
    navigator.clipboard.writeText(text).then(function () {
        emitter.emit("message", { type: "success", msg: "Copied to clipboard!" });
    }, function (err) {
        emitter.emit("message", { type: "error", msg: "Unable to copy to clipboard!" });
    });
}

window.ellipsis = function (text, length) {
    if (text.length > length) {
        return text.substring(0, length) + "...";
    }
    return text;
}

window.pwGen = function (length) {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyz.:,;!@#$%^&*-_/\\()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var password = "";
    for (var i = 0; i <= length; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
    }
    return password;
}

window.passwordRate = function (password) {
    var strength = 0;
    if (password.match(/[a-z]+/)) {
        strength += 1;
    }
    if (password.match(/[A-Z]+/)) {
        strength += 1;
    }
    if (password.match(/[0-9]+/)) {
        strength += 1;
    }
    if (password.match(/[.:,;$!?{}[\]()/\\|&%*@+^]+/)) {
        strength += 1;
    }
    if (password.length > 10) {
        strength += 1;
    }
    if (password.length > 20) {
        strength += 1;
    }
    return strength;
}