class Despesas {
    constructor() {
        this.obterFornecedores();
        this.mascara();
        this.selectpickerValidation()
        this.selectpickerValidation2()
        this.obterListaDespesas()
    }

    dataUStoBR(data)
    {
        var us = data.split("-");
        return us[2]+"/"+us[1]+"/"+us[0]
    }

    obterStatusPagamento(item)
    {
        var ret = `<span class="badge badge-danger">PAGAMENTO PENDENTE</span>`;
        var valorDespesa = parseFloat(item.valorDespesa);
        var valorPagamento = parseFloat(item.valorPagamento);
        if(valorDespesa == valorPagamento)
        {
            ret = `<span class="badge badge-success">PAGO</span>`
        }
        else if(valorPagamento > 0 && valorPagamento < valorDespesa)
        {
            ret = `<span class="badge badge-primary">PAGO PARCIALMENTE</span>`
        }else if(valorPagamento > valorDespesa)
        {
            ret = `<span class="badge badge-warning">PAGAMENTO EXCEDIDO</span>`
        }
        return ret;
    }

    obterListaDespesas(){
        $.ajax({
            url: "/Despesas/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    var html = ``
                    resultSet = res.resultSet;
                    res.resultSet.forEach((item,index) => {
                        html += `<tr>
                                    <td>${item.descricao}</td>
                                    <td>${item.nomeFornecedor}</td>
                                    <td>${item.nomeUsuario}</td>
                                    <td>${item.tipo}</td>
                                    <td>${this.dataUStoBR(item.dataVencimento)}</td>
                                    <td>${parseFloat(item.valorDespesa).toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                                    <td>${!!item.dataPagamento ? this.dataUStoBR(item.dataPagamento) : ""}</td>
                                    <td>${!!item.valorPagamento ? parseFloat(item.valorPagamento).toLocaleString('pt-br', {minimumFractionDigits: 2}) : ""}</td>
                                    <td>${this.obterStatusPagamento(item)}</td>
                                    <td><button type="button" class="btn btn-outline-primary" onclick="_despesas.abrirModalEditar('${index}')">Alterar</button><button type="button" class="btn btn-outline-danger ml-2" onclick="_despesas.excluir('${index}')">Excluir</button></td>
                                 </tr>`
                    })
                    $("#tbody").html(html);
                    this.dataTable();
                }else{
                    $("#tbody").html(``)
                    this.dataTable();
                }
            },
            error: (err) => {
                console.log(err);
                $("#tbody").html(``);
                this.dataTable();
            }
        })
    }

    selectpickerValidation()
    {
        jQuery.validator.addMethod("selectpicker", (value,element,params) => {
            if(value.length == 0)
            {
                if(element.parentElement.children[3])
                {
                    element.parentElement.children[3].remove()
                }
                element.parentElement.childNodes[2].insertAdjacentHTML("afterEnd",`<label id="fornecedor-error" class="error" for="fornecedor">Este campo ?? requerido.</label>`)
                return false;
            }
            else{
                if(element.parentElement.children[3])
                {
                    element.parentElement.children[3].remove()
                }
                return true;
            }
        },"Este campo ?? requerido")
    }

    selectpickerValidation2()
    {
        jQuery.validator.addMethod("selectpick", (value,element,params) => {
            if(value.length == 0)
            {
                if(document.getElementById("fornecedorModal-error"))
                {
                    document.getElementById("fornecedorModal-error").remove();
                }
                element.parentElement.childNodes[1].insertAdjacentHTML("afterEnd",`<label id="fornecedorModal-error" class="error" for="fornecedorModal">Este campo ?? requerido.</label>`)
                return false;
            }
            else{
                if(document.getElementById("fornecedorModal-error"))
                {
                    document.getElementById("fornecedorModal-error").remove();
                }
                return true;
            }
        },"Este campo ?? requerido")
    }

    mascara()
    {
        //Cadastrar
        $("#dataVencimento").val(new Date().toISOString().split("T")[0])
        $('#valorDespesa').mask("#.##0,00", {reverse: true});
        // $("#dataPagamento").val(new Date().toISOString().split("T")[0])
        $('#valorPagamento').mask("#.##0,00", {reverse: true});

        //Atualizar Modal
        $("#dataVencimentoModal").val(new Date().toISOString().split("T")[0])
        $('#valorDespesaModal').mask("#.##0,00", {reverse: true});
        // $("#dataPagamentoModal").val(new Date().toISOString().split("T")[0])
        $('#valorPagamentoModal').mask("#.##0,00", {reverse: true});
    }

    obterFornecedores(padrao = null,selector = "#fornecedor")
    {
        $.ajax({
            url: "/Gerenciar/Fornecedor/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    var options = '';
                    res.resultSet.forEach(item => {
                        options += `<option value="${item.idFornecedor}" ${padrao == item.idFornecedor ? "selected" : ""}>${item.descricao}</option>`
                    })
                    $(selector).html(options);
                    $(selector).selectpicker("refresh");
                }
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    excluir(index)
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
                var dados = resultSet[index];
                $.ajax({
                    url : "/Despesas/Excluir",
                    type: "POST",
                    data: dados,
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status)
                        {
                            table.destroy();
                            _despesas.obterListaDespesas();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
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

    abrirModalEditar(index)
    {
        var dados = resultSet[index];
        this.obterFornecedores(dados.idFornecedor,"#fornecedorModal");
        $("#descricaoModal").val(dados.descricao);
        $("#tipoModal").val(dados.tipo);
        $("#dataVencimentoModal").val(dados.dataVencimento);
        $("#idDespesa").val(dados.idDespesa);
        $("#valorPagamentoModal").val(!!dados.valorPagamento ? parseFloat(dados.valorPagamento).toLocaleString('pt-br', {minimumFractionDigits: 2}) : "");
        $("#valorDespesaModal").val(!!dados.valorDespesa ? parseFloat(dados.valorDespesa).toLocaleString('pt-br', {minimumFractionDigits: 2}) : "");
        $("#dataPagamentoModal").val(!!dados.dataPagamento ? dados.dataPagamento : "");
        $("#modalDespesa").modal("show");
        $("#botaoSalvar").on("click", () => {
            $("#formDespesaModal").validate({
                rules: {
                    fornecedorModal:
                        {
                            selectpick: true
                        }
                },
                submitHandler: (form) => {
                    if(document.getElementById("dataVencimentoModal").value < new moment().format("Y-MM-DD")) {
                        Swal.fire({
                            icon: 'info',
                            title: 'A Data de Vencimento ?? anterior ?? data atual. Deseja cadastrar mesmo assim?',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Cadastrar',
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: "/Despesas/Atualizar",
                                    type: "POST",
                                    data: transForm.serialize(form),
                                    success: (res) => {
                                        Swal.fire({
                                            title: res.message,
                                            icon: res.icon
                                        })
                                        if (res.status) {
                                            $("#modalDespesa").modal("hide");
                                            table.destroy();
                                            _despesas.obterListaDespesas();
                                        }
                                    },
                                    error: (err) => {
                                        console.log(err);
                                    }
                                })
                            }
                        });
                    }else{
                        $.ajax({
                            url: "/Despesas/Atualizar",
                            type: "POST",
                            data: transForm.serialize(form),
                            success: (res) => {
                                Swal.fire({
                                    title: res.message,
                                    icon: res.icon
                                })
                                if (res.status) {
                                    $("#modalDespesa").modal("hide");
                                    table.destroy();
                                    _despesas.obterListaDespesas();
                                }
                            },
                            error: (err) => {
                                console.log(err);
                            }
                        })
                    }
                }
            })
        })
    }

    limparCampos()
    {
        $("#descricao").val("");
        $("#fornecedor").val("");
        $("#fornecedor").selectpicker("refresh");
        $("#dataVencimento").val(new Date().toISOString().split("T")[0])
        $("#valorPagamento").val("");
    }

    gerarRelatorio()
    {
        $("#formRelatorio").validate({
            submitHandler: function(form) {
                var dados = transForm.serialize(form);
                if(dados.relDataInicial < dados.relDataFinal) {
                    var params = `?dataInicial=${dados.relDataInicial}&dataFinal=${dados.relDataFinal}`;
                    window.open("/Despesas/Relatorio"+params,"_blank");
                }
                else{
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
                        icon: "danger",
                        title: "Data Inicial deve ser menor que Data Final"
                    })
                }
            }
        })
    }


    cadastrar()
    {

        $("#formDespesas").validate({
            rules: {
                fornecedor: {
                    selectpicker: true
                }
            },
            submitHandler: function(form) {
                if(document.getElementById("dataVencimento").value < new moment().format("Y-MM-DD"))
                {
                    Swal.fire({
                        icon: 'info',
                        title: 'A Data de Vencimento ?? anterior ?? data atual. Deseja cadastrar mesmo assim?',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Cadastrar',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#dc3545',
                    }).then((res) => {
                        if (res.isConfirmed) {
                            $.ajax({
                                url: "/Despesas/Gravar",
                                type: "POST",
                                data: transForm.serialize(form),
                                success: (res) => {
                                    Swal.fire({
                                        title: res.message,
                                        icon: res.icon
                                    })
                                    if(res.status){
                                        _despesas.limparCampos();
                                        table.destroy();
                                        _despesas.obterListaDespesas();
                                    }
                                },
                                error: (res) => {
                                    console.log(res);
                                }
                            })
                        }
                    })
                }else{
                    $.ajax({
                        url: "/Despesas/Gravar",
                        type: "POST",
                        data: transForm.serialize(form),
                        success: (res) => {
                            Swal.fire({
                                title: res.message,
                                icon: res.icon
                            })
                            if(res.status){
                                _despesas.limparCampos();
                                table.destroy();
                                _despesas.obterListaDespesas();
                            }
                        },
                        error: (res) => {
                            console.log(res);
                        }
                    })
                }
            }
        });
    }
}

var _despesas;
var table;
var resultSet;

$(document).ready(() => {
    _despesas = new Despesas();
})