class Administrador {
    constructor() {
        this.mascaras();
        this.mascarasModal();
        this.obterListaAdministradores();
        this.obterDadosViaCep()
    }

    obterDadosViaCep()
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

    dataBRtoUS(data)
    {
        var us = data.split("/");
        return us[2]+"-"+us[1]+"-"+us[0]
    }

    atualizar()
    {
        $("#formAlterar").validate({
            submitHandler: (form) => {
                $.ajax({
                    url: "/Gerenciar/Administrador/Atualizar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){
                            table.destroy();
                            _administrador.obterListaAdministradores();
                        }
                    },
                    error: (res) => {
                        console.log(res);
                    }
                })
            }
        })
    }

    preencherModal(idAdministrador,nome,salario,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email)
    {

        $("#ModalIdAdministrador").val(idAdministrador);
        $("#ModalNome").val(nome);
        $("#ModalSalario").val(parseFloat(salario).toLocaleString('pt-br', {minimumFractionDigits: 2}));
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
        $("#botaoSalvar").attr("onclick",`_administrador.atualizar()`);
    }

    obterListaAdministradores()
    {
        $.ajax({
            url: "/Gerenciar/Administrador/ObterTodos",
            type: "GET",
            beforeSend: () => {

            },
            complete: () => {

            },
            success: (res) => {
                if(res.status){
                    var html = "";
                    res.resultSet.forEach((item,i)=> {
                        html += `<tr>
                                        <td>${item.idAdministrador}</td>
                                        <td>
                                            <strong>Nome:</strong> ${item.nome}<br>
                                            <strong>Sal??rio:</strong> ${parseFloat(item.salario).toLocaleString('pt-br', {minimumFractionDigits: 2})}<br>
                                            <strong>Data de Nascimento:</strong> ${item.dataNascimento}<br>
                                            <strong>Sexo:</strong> ${item.sexo}<br>
                                            <strong>Estado Civil:</strong> ${item.estadoCivil}<br>
                                        </td>
                                        <td>
                                            <strong>Rua:</strong> ${item.rua}<br>
                                            <strong>N??mero:</strong> ${item.nrcasa}<br>
                                            <strong>Bairro:</strong> ${item.bairro}<br>
                                            <strong>Cidade:</strong> ${item.cidade}<br>
                                            <strong>Estado:</strong> ${item.uf}<br>
                                            <strong>Pais:</strong> ${item.pais}<br>
                                            <strong>Cep:</strong> ${item.cep}<br>
                                        </td>
                                        <td>
                                            <strong>Contato:</strong> ${!!item.contato ? item.contato : ""}<br>
                                            <strong>Email:</strong> ${item.email}<br>
                                        </td>  
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalAluno" onclick="_administrador.preencherModal('${item.idAdministrador}','${item.nome}','${item.salario}','${item.dataNascimento}','${item.sexo}','${item.estadoCivil}','${item.rua}','${item.nrcasa}','${item.bairro}','${item.cidade}','${item.uf}','${item.pais}','${item.cep}','${item.contato}','${item.email}')">Alterar</button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="_administrador.excluir('${item.idAdministrador}')">Excluir</button>
                                        </td>
                                 </tr>`
                    })
                    $("#tbody").html(html);
                    _administrador.dataTable();
                }else {
                    $("#tbody").html(``);
                    _administrador.dataTable();
                }
            },
            error: (res) => {
                console.log(res);
                $("#tbody").html(``);
                _administrador.dataTable();
            }
        })
    }

    dataTable()
    {
        table = $(".table").DataTable({
            language: {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ at?? _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 at?? 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "paginate": {
                    "next": "Pr??ximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "??ltimo"
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
                        "1": "1 c??lula selecionada",
                        "_": "%d c??lulas selecionadas"
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
                    "collection": "Cole????o  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Visibilidade da Coluna",
                    "colvisRestore": "Restaurar Visibilidade",
                    "copy": "Copiar",
                    "copyKeys": "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a ??rea de transfer??ncia do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
                    "copyTitle": "Copiar para a ??rea de Transfer??ncia",
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
                    "fill": "Preencher todas as c??lulas com",
                    "fillHorizontal": "Preencher c??lulas horizontalmente",
                    "fillVertical": "Preencher c??lulas verticalmente"
                },
                "lengthMenu": "Exibir _MENU_ resultados por p??gina",
                "searchBuilder": {
                    "add": "Adicionar Condi????o",
                    "button": {
                        "0": "Construtor de Pesquisa",
                        "_": "Construtor de Pesquisa (%d)"
                    },
                    "clearAll": "Limpar Tudo",
                    "condition": "Condi????o",
                    "conditions": {
                        "date": {
                            "after": "Depois",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "not": "N??o",
                            "notBetween": "N??o Entre",
                            "notEmpty": "N??o Vazio"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "gt": "Maior Que",
                            "gte": "Maior ou Igual a",
                            "lt": "Menor Que",
                            "lte": "Menor ou Igual a",
                            "not": "N??o",
                            "notBetween": "N??o Entre",
                            "notEmpty": "N??o Vazio"
                        },
                        "string": {
                            "contains": "Cont??m",
                            "empty": "Vazio",
                            "endsWith": "Termina Com",
                            "equals": "Igual",
                            "not": "N??o",
                            "notEmpty": "N??o Vazio",
                            "startsWith": "Come??a Com"
                        },
                        "array": {
                            "contains": "Cont??m",
                            "empty": "Vazio",
                            "equals": "Igual ??",
                            "not": "N??o",
                            "notEmpty": "N??o vazio",
                            "without": "N??o possui"
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
                    "leftTitle": "Crit??rios Externos",
                    "rightTitle": "Crit??rios Internos"
                },
                "searchPanes": {
                    "clearMessage": "Limpar Tudo",
                    "collapse": {
                        "0": "Pain??is de Pesquisa",
                        "_": "Pain??is de Pesquisa (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Nenhum Painel de Pesquisa",
                    "loadMessage": "Carregando Pain??is de Pesquisa...",
                    "title": "Filtros Ativos"
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Pr??ximo",
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
                        "2": "Mar??o",
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
                        "Ter??a-feira",
                        "Quarta-feira",
                        "Quinte-feira",
                        "Sexta-feira",
                        "S??bado"
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
                        "system": "Ocorreu um erro no sistema (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Mais informa????es<\/a>)."
                    },
                    "multi": {
                        "noMulti": "Essa entrada pode ser editada individualmente, mas n??o como parte do grupo",
                        "restore": "Desfazer altera????es",
                        "title": "Multiplos valores",
                        "info": "Os itens selecionados cont??m valores diferentes para esta entrada. Para editar e definir todos os itens para esta entrada com o mesmo valor, clique ou toque aqui, caso contr??rio, eles manter??o seus valores individuais."
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
        $("#salario").mask("#.##0,00", {reverse: true});
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
        $("#ModalSalario").mask("#.##0,00", {reverse: true});
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

    excluir(idAdministrador)
    {
        Swal.fire({
            icon: 'info',
            title: 'Confirmar Exclus??o?',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Excluir',
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if(res.isConfirmed)
            {
                $.ajax({
                    url : "/Gerenciar/Administrador/Excluir",
                    type: "POST",
                    data: {idAdministrador},
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status)
                        {
                            table.destroy();
                            _administrador.obterListaAdministradores();
                        }
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
        $("#formCadastro").validate({
            submitHandler: (form) => {
                $.ajax({
                    url: "/Gerenciar/Administrador/Gravar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){

                            table.destroy();
                            _administrador.obterListaAdministradores();
                        }
                    },
                    error: (res) => {
                        console.log(res);
                    }
                })
            }
        })
    }
}

var _administrador;
var table;

$(document).ready(() => {
    _administrador = new Administrador();
})