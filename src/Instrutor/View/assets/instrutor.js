class Instrutor {
    constructor() {
        this.mascaras();
        this.mascarasModal();
        this.obterListaInstrutores();
        this.buscarPorCEP();
        this.validacoesPersonalizadas();
    }

    dataBRtoUS(data)
    {
        var us = data.split("/");
        return us[2]+"-"+us[1]+"-"+us[0]
    }

    validacoesPersonalizadas(){
        jQuery.validator.addMethod("validarCPF", function(value, element) {
            value = jQuery.trim(value);

            value = value.replace('.','');
            value = value.replace('.','');
            let cpf = value.replace('-','');
            while(cpf.length < 11) cpf = "0"+ cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
            var a = [];
            var b = new Number;
            var c = 11;
            for (var i=0; i<11; i++){
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
            }
            var x;
            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
            b = 0;
            c = 11;
            var y;
            for (y=0; y<10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

            var retorno = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

            return this.optional(element) || retorno;

        }, "Informe um CPF válido");
    }

    excluir(idInstrutor)
    {
        Swal.fire({
            icon: 'info',
            title: 'Confirmar Exclusão?',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Excluir',
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if(res.isConfirmed)
            {
                $.ajax({
                    url : "/Gerenciar/Instrutor/Excluir",
                    type: "POST",
                    data: {idInstrutor},
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status)
                        {
                           _table.destroy();
                           _instrutor.obterListaInstrutores();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    atualizar()
    {
        $("#formInstrutorModal").validate({
            rules: {
                ModalCPF: {validarCPF: true}
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "/Gerenciar/Instrutor/Atualizar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        if(res.status){
                            _table.destroy();
                            _instrutor.obterListaInstrutores();
                        }
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    },
                    error: (res) => {
                        console.log(res);
                    }
                })
            }
        })
    }



    preencherModal(idInstrutor,nome,salario,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email,rg,cpf,dataAdmissao,dataDemissao)
    {
        $("#ModalIdInstrutor").val(idInstrutor);
        $("#ModalNome").val(nome);
        $("#ModalSalario").val(salario);
        $("#ModalDataNascimento").val(this.dataBRtoUS(dataNascimento));
        $("#ModalSexo").val(sexo);
        $("#ModalEstadoCivil").val(estadoCivil);
        $("#ModalRua").val(rua);
        $("#ModalNrCasa").val(nrcasa);
        $("#ModalBairro").val(bairro);
        $("#ModalCidade").val(cidade);
        $("#ModalEstado").val(uf);
        $("#ModalPais").val(pais);
        $("#ModalCep").val(cep);
        $("#ModalContato").val(contato);
        $("#ModalEmail").val(email);
        $("#ModalRG").val(rg);
        $("#ModalCPF").val(cpf);
        $("#ModalDataAdmissao").val(this.dataBRtoUS(dataAdmissao));
        $("#ModalDataDemissao").val(this.dataBRtoUS(dataDemissao));
        $("#botaoSalvar").attr("onclick",`_instrutor.atualizar()`);
    }

    obterListaInstrutores()
    {
        $.ajax({
            url: "/Gerenciar/Instrutor/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status){
                    var html = "";
                    res.resultSet.forEach((item,i)=> {
                        html += `<tr>
                                        <td>${item.idInstrutor}</td>
                                        <td>
                                            <b>Nome: </b>${item.nome}<br>
                                            <b>Salário: </b>${parseFloat(item.salario).toLocaleString('pt-br', {minimumFractionDigits: 2})}<br>
                                            <b>Data de Nascimento: </b>${item.dataNascimento}<br>
                                            <b>Sexo: </b>${item.sexo}<br>
                                            <b>Estado Civil: </b>${item.estadoCivil}<br>
                                            <b>CPF: </b>${item.cpf}<br>
                                            <b>RG: </b>${item.rg}<br>
                                        </td>
                                        <td>
                                            <b>Rua: </b>${item.rua}<br>
                                            <b>Número: </b>${item.nrcasa}<br>
                                            <b>Bairro: </b>${item.bairro}<br>
                                            <b>Cidade: </b>${item.cidade}<br>
                                            <b>Estado: </b>${item.uf}<br>
                                            <b>Pais: </b>${item.pais}<br>
                                            <b>Cep: </b>${item.cep}<br>
                                        </td>
                                        <td>
                                            <b>Telefone: </b>${!!item.contato ? item.contato : ""}<br>
                                            <b>Email: </b>${item.email}<br>
                                        </td>
                                        <td>
                                            <b>Data de Admissão: </b>${item.dataAdmissao}<br>
                                            <b>Data de Demissão: </b>${item.dataDemissao != null ? item.dataDemissao : ""}<br>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalAluno" onclick="_instrutor.preencherModal('${item.idInstrutor}','${item.nome}','${item.salario}','${item.dataNascimento}','${item.sexo}','${item.estadoCivil}','${item.rua}','${item.nrcasa}','${item.bairro}','${item.cidade}','${item.uf}','${item.pais}','${item.cep}','${item.contato}','${item.email}','${item.rg}','${item.cpf}','${item.dataAdmissao}','${item.dataDemissao}',)">Alterar</button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="_instrutor.excluir('${item.idInstrutor}')"> Excluir</button>
                                        </td>
                                 </tr>`
                    })
                    $("#tbody").html(html);

                }else{
                    $("#tbody").html(``);

                }
                _instrutor.dataTable();
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    dataTable()
    {
        _table = $(".table").DataTable({
            language: {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                },
                "aria": {
                    "sortAscending": ": Ordenar colunas de forma ascendente",
                    "sortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "1": "Selecionado 1 linha"
                    },
                    "cells": {
                        "1": "1 célula selecionada",
                        "_": "%d células selecionadas"
                    },
                    "columns": {
                        "1": "1 coluna selecionada",
                        "_": "%d colunas selecionadas"
                    }
                },
                "buttons": {
                    "copySuccess": {
                        "1": "Uma linha copiada com sucesso",
                        "_": "%d linhas copiadas com sucesso"
                    },
                    "collection": "Coleção  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Visibilidade da Coluna",
                    "colvisRestore": "Restaurar Visibilidade",
                    "copy": "Copiar",
                    "copyKeys": "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
                    "copyTitle": "Copiar para a Área de Transferência",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todos os registros",
                        "_": "Mostrar %d registros"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Preencher todas as células com",
                    "fillHorizontal": "Preencher células horizontalmente",
                    "fillVertical": "Preencher células verticalmente"
                },
                "lengthMenu": "Exibir _MENU_ resultados por página",
                "searchBuilder": {
                    "add": "Adicionar Condição",
                    "button": {
                        "0": "Construtor de Pesquisa",
                        "_": "Construtor de Pesquisa (%d)"
                    },
                    "clearAll": "Limpar Tudo",
                    "condition": "Condição",
                    "conditions": {
                        "date": {
                            "after": "Depois",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "not": "Não",
                            "notBetween": "Não Entre",
                            "notEmpty": "Não Vazio"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "gt": "Maior Que",
                            "gte": "Maior ou Igual a",
                            "lt": "Menor Que",
                            "lte": "Menor ou Igual a",
                            "not": "Não",
                            "notBetween": "Não Entre",
                            "notEmpty": "Não Vazio"
                        },
                        "string": {
                            "contains": "Contém",
                            "empty": "Vazio",
                            "endsWith": "Termina Com",
                            "equals": "Igual",
                            "not": "Não",
                            "notEmpty": "Não Vazio",
                            "startsWith": "Começa Com"
                        },
                        "array": {
                            "contains": "Contém",
                            "empty": "Vazio",
                            "equals": "Igual à",
                            "not": "Não",
                            "notEmpty": "Não vazio",
                            "without": "Não possui"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Excluir regra de filtragem",
                    "logicAnd": "E",
                    "logicOr": "Ou",
                    "title": {
                        "0": "Construtor de Pesquisa",
                        "_": "Construtor de Pesquisa (%d)"
                    },
                    "value": "Valor",
                    "leftTitle": "Critérios Externos",
                    "rightTitle": "Critérios Internos"
                },
                "searchPanes": {
                    "clearMessage": "Limpar Tudo",
                    "collapse": {
                        "0": "Painéis de Pesquisa",
                        "_": "Painéis de Pesquisa (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Nenhum Painel de Pesquisa",
                    "loadMessage": "Carregando Painéis de Pesquisa...",
                    "title": "Filtros Ativos"
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Próximo",
                    "hours": "Hora",
                    "minutes": "Minuto",
                    "seconds": "Segundo",
                    "amPm": [
                        "am",
                        "pm"
                    ],
                    "unknown": "-",
                    "months": {
                        "0": "Janeiro",
                        "1": "Fevereiro",
                        "10": "Novembro",
                        "11": "Dezembro",
                        "2": "Março",
                        "3": "Abril",
                        "4": "Maio",
                        "5": "Junho",
                        "6": "Julho",
                        "7": "Agosto",
                        "8": "Setembro",
                        "9": "Outubro"
                    },
                    "weekdays": [
                        "Domingo",
                        "Segunda-feira",
                        "Terça-feira",
                        "Quarta-feira",
                        "Quinte-feira",
                        "Sexta-feira",
                        "Sábado"
                    ]
                },
                "editor": {
                    "close": "Fechar",
                    "create": {
                        "button": "Novo",
                        "submit": "Criar",
                        "title": "Criar novo registro"
                    },
                    "edit": {
                        "button": "Editar",
                        "submit": "Atualizar",
                        "title": "Editar registro"
                    },
                    "error": {
                        "system": "Ocorreu um erro no sistema (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Mais informações<\/a>)."
                    },
                    "multi": {
                        "noMulti": "Essa entrada pode ser editada individualmente, mas não como parte do grupo",
                        "restore": "Desfazer alterações",
                        "title": "Multiplos valores",
                        "info": "Os itens selecionados contêm valores diferentes para esta entrada. Para editar e definir todos os itens para esta entrada com o mesmo valor, clique ou toque aqui, caso contrário, eles manterão seus valores individuais."
                    },
                    "remove": {
                        "button": "Remover",
                        "confirm": {
                            "_": "Tem certeza que quer deletar %d linhas?",
                            "1": "Tem certeza que quer deletar 1 linha?"
                        },
                        "submit": "Remover",
                        "title": "Remover registro"
                    }
                },
                "decimal": ","
            }
        })
    }

    mascaras()
    {
        $("#cep").mask("00000-000")
        $("#cpf").mask("000.000.000-00")
        $("#rg").mask("00.000.000-0")
        $('#salario').mask("#.##0,00", {reverse: true});
        var behavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

        $('#contato').mask(behavior, options);
    }

    mascarasModal()
    {
        $("#ModalCep").mask("00000-000")
        $("#ModalCPF").mask("000.000.000-00")
        $("#ModalRG").mask("00.000.000-0")
        $('#ModalSalario').mask("#.##0,00", {reverse: true});
        var behavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

        $('#ModalContato').mask(behavior, options);
    }


    buscarPorCEP()
    {
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
        $("#ModalCep").on("focusout", () => {
            var cep = $("#ModalCep").val();
            if(cep != "")
            {
                $.ajax({
                    url: `https://viacep.com.br/ws/${cep}/json/`,
                    type: "GET",
                    success: (res) => {
                        $("#ModalEstado").val(res.uf);
                        $("#ModalBairro").val(res.bairro);
                        $("#ModalCidade").val(res.localidade);
                        $("#ModalRua").val(res.logradouro);
                        $("#ModalCep").val(res.cep);
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    cadastrar()
    {
        $("#formInstrutores").validate({
            rules: {
                cpf: {validarCPF:true}
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "/Gerenciar/Instrutor/Gravar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        if(res.status){
                            _table.destroy();
                            _instrutor.obterListaInstrutores();
                        }Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    },
                    error: (res) => {
                        console.log(res);
                    }
                })
            }
        });
    }


}

var _instrutor;
var _table;

$(document).ready(() => {
    _instrutor = new Instrutor();

})