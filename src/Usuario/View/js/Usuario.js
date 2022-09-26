class Usuario {
    constructor() {
        this.#rememberEventListener();
        this.#getRememberCredentials();
    }

    #getRememberCredentials()
    {
        var email = localStorage.getItem("email")
        var senha = localStorage.getItem("senha");
        var remember = localStorage.getItem("remember");
        if(email && senha && remember)
        {
            document.getElementById("email").value = email;
            document.getElementById("senha").value = this.#descriptografar(senha);
            document.getElementById("remember").checked = remember;
        }
    }

    #criptografar(text)
    {
        var key = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ];
        var textBytes = aesjs.utils.utf8.toBytes(text);
        var aesCtr = new aesjs.ModeOfOperation.ctr(key, new aesjs.Counter(5));
        var encryptedBytes = aesCtr.encrypt(textBytes);
        var encryptedHex = aesjs.utils.hex.fromBytes(encryptedBytes);
        return encryptedHex;
    }

    #descriptografar(encryptedHex)
    {
        var key = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ];
        var encryptedBytes = aesjs.utils.hex.toBytes(encryptedHex);
        var aesCtr = new aesjs.ModeOfOperation.ctr(key, new aesjs.Counter(5));
        var decryptedBytes = aesCtr.decrypt(encryptedBytes);
        var decryptedText = aesjs.utils.utf8.fromBytes(decryptedBytes);
        return decryptedText;
    }

    #rememberEventListener()
    {
        document.getElementById("remember").addEventListener("change", (evt) => {
            var checado = evt.target.checked;
            var email = document.getElementById("email").value;
            var senha = this.#criptografar(document.getElementById("senha").value);
            if(checado && !!email && !!senha)
            {
                localStorage.setItem("email",email);
                localStorage.setItem("senha",senha);
                localStorage.setItem("remember",checado);
            }
            else{
                localStorage.removeItem("email");
                localStorage.removeItem("senha");
                localStorage.removeItem("remember");
            }
        })
    }

    logar()
    {
        var params = {
            email : $("#email").val(),
            senha : $("#senha").val()
        };
        $.ajax({
            url: "/Usuario/Login",
            method: "POST",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(params),
            success: (res) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: res.icon,
                    title: res.message
                })
                if(res.status)
                {
                    setTimeout(() => {
                        window.location.href = "/Dashboard";
                    },2000);
                }
            },
            error: (res) => {
                console.log(res);
            }
        })
    }
}

var _usuario;

$(document).ready(() => {
    _usuario = new Usuario();
})