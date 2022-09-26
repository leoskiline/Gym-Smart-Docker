class Sistema {

    constructor() {
        this.init();
    }

    init()
    {
        $('#cep').mask('00000-000');
        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask('(00) 00000-0000');
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

        $('#contato').mask(SPMaskBehavior, spOptions);
        $('#salario').mask("#.##0,00", {reverse: true});
        $("#cep").on("focusout", () => {
            var cep = $("#cep").val();
            if(cep != "")
            {
                $.ajax({
                    url: `https://viacep.com.br/ws/${cep}/json/`,
                    type: "GET",
                    success: (res) => {
                        $("#estado").val(res.uf);
                        $("#bairro").val(res.bairro);
                        $("#cidade").val(res.localidade);
                        $("#rua").val(res.logradouro);
                        $("#cep").val(res.cep);
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    validarCNPJ()
    {
        jQuery.validator.addMethod("validarCNPJ", function(value,elem) {
            if (!value) return false

            // Aceita receber o valor como string, número ou array com todos os dígitos
            const isString = typeof value === 'string'
            const validTypes = isString || Number.isInteger(value) || Array.isArray(value)

            // Elimina valor em formato inválido
            if (!validTypes) return false

            // Filtro inicial para entradas do tipo string
            if (isString) {
                // Limita ao máximo de 18 caracteres, para CNPJ formatado
                if (value.length > 18) return false

                // Teste Regex para veificar se é uma string apenas dígitos válida
                const digitsOnly = /^\d{14}$/.test(value)
                // Teste Regex para verificar se é uma string formatada válida
                const validFormat = /^\d{2}.\d{3}.\d{3}\/\d{4}-\d{2}$/.test(value)

                // Se o formato é válido, usa um truque para seguir o fluxo da validação
                if (digitsOnly || validFormat) true
                // Se não, retorna inválido
                else return false
            }

            // Guarda um array com todos os dígitos do valor
            const match = value.toString().match(/\d/g)
            const numbers = Array.isArray(match) ? match.map(Number) : []

            // Valida a quantidade de dígitos
            if (numbers.length !== 14) return false

            // Elimina inválidos com todos os dígitos iguais
            const items = [...new Set(numbers)]
            if (items.length === 1) return false

            // Cálculo validador
            const calc = (x) => {
                const slice = numbers.slice(0, x)
                let factor = x - 7
                let sum = 0

                for (let i = x; i >= 1; i--) {
                    const n = slice[x - i]
                    sum += n * factor--
                    if (factor < 2) factor = 9
                }

                const result = 11 - (sum % 11)

                return result > 9 ? 0 : result
            }

            // Separa os 2 últimos dígitos de verificadores
            const digits = numbers.slice(12)

            // Valida 1o. dígito verificador
            const digit0 = calc(12)
            if (digit0 !== digits[0]) return false

            // Valida 2o. dígito verificador
            const digit1 = calc(13)
            return digit1 === digits[1]
        },"CNPJ informado não é válido.");
    }


    Atualizar()
    {
        this.validarCNPJ();
        $("#formConfiguracao").validate({
            rules: {
                cnpj  : {
                    validarCNPJ: true
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: "/Parametrizacao/Atualizar",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        setTimeout(() => {
                            window.location.reload();
                        },2000);
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        });
    }
}

var _Sistema;

$(document).ready(() => {
    _Sistema = new Sistema();
})