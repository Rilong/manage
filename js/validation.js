    var messageBlockErrorPhp = $(".messageErrorPHP");
    var messageBlockError = $(".messageError");
    var messageBlockSuccess = $(".messageSuccess");
    var checkLogin = $("input[name='checkLogin']");
    var message = "";
   
    function setMessage(message, type) {
        if (type == "error") {
            if (messageBlockError.is(":hidden")) {
                if (messageBlockSuccess.is(":visible")) {
                    messageBlockSuccess.slideUp(800);
                }
                if (messageBlockErrorPhp.is(":visible"))
                    messageBlockErrorPhp.slideUp(800);
                messageBlockError.html(message);
                messageBlockError.slideDown(800);
            }else  messageBlockError.html(message);
        }else if (type == "success") {
            if (messageBlockError.is(":visible")) {
                messageBlockError.slideUp(800);
            }
            if (messageBlockErrorPhp.is(":visible"))
                messageBlockErrorPhp.slideUp(800);
            messageBlockSuccess.html(message);
            messageBlockSuccess.slideDown(800);
        }else messageBlockError.html(message);
    }
    // checkLogin
    checkLogin.bind("click", function () {
        var login = $("input[name='login']").val();
        if (login.length == 0)
            message = "Введіть логін!";
        else if (!login.match(/[a-z]/i))
            message = "Некоректний логін";

        if (message.length != 0) {
            setMessage(message, "error");
            message = "";
        }else {
            $.ajax({
                url: "../ajax/checkLogin.php",
                type: "POST",
                dataType: "html",
                data: {login: login},
                success: function (data) {
                    if (data == "no")
                        setMessage("Логін зайнятий!", "error");
                    else setMessage("Логін вільний!", "success")
                }
            });
        }

    });

    // validate form auth
    $("form[name='reg']").submit(function () {
        var login = $("input[name='login']").val();
        var name = $("input[name='name']").val();
        var password = $("input[name='password']").val();
        var passwordRepeat = $("input[name='passwordRepeat']").val();
        var email = $("input[name='email']").val();
        if (login.length == 0)
            message = "Введіть логін!";
        else if (!login.match(/[a-z]/i))
            message = "Некоректний логін";
        else if (login.length > 20)
            message = "Логін занадто довгий!";
        else if (name.length == 0)
            message = "Введіть ім'я!";
        else if (name.length > 30)
            message = "Ім'я занадто довге!";
        else if (password.length == 0)
            message = "Введіть пароль!";
        else if (password.length < 6)
            message = "Пароль занадто короткий!";
        else if (password != passwordRepeat)
            message = "Паролі не співпадають!";
        else if (email.length == 0)
            message = "Введіть E-mail!";
        else if (!email.match(/^[a-z0-9_][a-z0-9\._-]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+$/i))
            message = "Некоректний E-mail!";
        if (message.length != 0) {
            setMessage(message, "error");
            message = "";
            return false;
        }else return true;
    });

    // validate form auth

    $("form[name='auth']").submit(function () {
        var login = $("input[name='login']").val();
        var password = $("input[name='password']").val();
        
        if (login.length == 0)
            message = "Введіть логін!";
        else if (password.length == 0)
            message = "Введіть пароль!"; 

        if (message.length != 0) {
            setMessage(message, "error");
            message = "";
            return false;
        }else return true;
    });