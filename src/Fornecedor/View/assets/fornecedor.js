class Fornecedor {
    constructor() {
        this.mascaras();
        this.mascarasModal();
        this.obterListaFornecedores();
    }

    excluir(idFornecedor) {
        Swal.fire({
            icon: 'info',
            title: 'Confirmar Exclusão?',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Excluir',
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: "/Gerenciar/Fornecedor/Excluir",
                    type: "POST",
                    data: {idFornecedor},
                    success: (res) => {
                        if(res.status){

                            table.destroy();
                            _fornecedor.obterListaFornecedores();
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
        });
    }

    atualizar()
    {
        $("#formFornecedorModal").validate({
            submitHandler: (form) => {
                $.ajax({
                    url: "/Gerenciar/Fornecedor/Atualizar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        if(res.status){

                            table.destroy();
                            _fornecedor.obterListaFornecedores();
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

    preencherModal(idFornecedor,descricao,contato,email,pessoaContato)
    {
        $("#ModalIdFornecedor").val(idFornecedor);
        $("#ModalDescricao").val(descricao);
        $("#ModalContato").val(contato);
        $("#ModalEmail").val(email);
        $("#ModalPessoaContato").val(pessoaContato);
        $("#botaoSalvar").attr("onclick",`_fornecedor.atualizar()`);
    }

    obterListaFornecedores()
    {
        $.ajax({
            url: "/Gerenciar/Fornecedor/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status){
                    var html = "";
                    res.resultSet.forEach((item,i)=> {
                        html += `<tr>
                                        <td>${item.descricao}</td>
                                        <td>${item.contato}</td>
                                        <td>${item.email}</td>
                                        <td>${item.pessoaContato}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalAluno" onclick="_fornecedor.preencherModal('${item.idFornecedor}','${item.descricao}','${item.contato}','${item.email}','${item.pessoaContato}')">Alterar</button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="_fornecedor.excluir('${item.idFornecedor}')">Excluir</button>
                                        </td>
                                 </tr>`
                    })
                    $("#tbody").html(html);
                }else {
                    $("#tbody").html(``)
                }
                _fornecedor.dataTable();
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    dataTable()
    {
        table = $(".table").DataTable({
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

    cadastrar()
    {
        $("#formFornecedor").validate({
            submitHandler: (form) => {

                $.ajax({
                    url: "/Gerenciar/Fornecedor/Gravar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        if(res.status){
                            table.destroy();
                            _fornecedor.obterListaFornecedores();
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
}

var _fornecedor;
var table;

$(document).ready(() => {
    _fornecedor = new Fornecedor();
})