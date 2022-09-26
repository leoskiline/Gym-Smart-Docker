class Planos {
    constructor() {
        this.obterAtividadesFisicas();
        this.mascara();
        this.aplicarDesconto();
        this.selectpickerValidation()
        this.selectpickerValidation2()
        this.obterListaPlanos()
    }

    obterAtividades(atv)
    {
        var html = ``;
        atv.forEach((item) => {
            html += `<span class="d-block">${item}</span>`
        })
        return html;
    }
    obterTipoPlano(idTipo){
        var tipoPlano = "Mensal";
        switch (parseInt(idTipo))
        {
            case 2:
                tipoPlano = "Bimestral";
                break;
            case 3:
                tipoPlano = "Trimestral";
                break;
            case 6:
                tipoPlano = "Semestral";
                break;
            case 12:
                tipoPlano = "Anual";
                break;
        }
        return tipoPlano
    }

    obterListaPlanos(){
        $.ajax({
            url: "/Planos/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    var html = ``
                    resultSet = res.resultSet;
                    res.resultSet.forEach((item,index) => {
                        html += `<tr>
                                    <td>${item.descricao}</td>
                                    <td>${this.obterAtividades(item.atividadesFisicas)}</td>
                                    <td>${this.obterTipoPlano(item.tipoPlano)}</td>
                                    <td>${parseFloat(item.valorPadrao).toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                                    <td>${item.percentualDesconto}</td>
                                    <td>${parseFloat(item.valorComDesconto).toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                                    <td><button type="button" class="btn btn-outline-primary" onclick="_planos.abrirModalEditar('${index}')">Alterar</button><button type="button" class="btn btn-outline-danger ml-2" onclick="_planos.excluir('${index}')">Excluir</button></td>
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
                element.parentElement.childNodes[2].insertAdjacentHTML("afterEnd",`<label id="atividadesFisicas-error" class="error" for="atividadesFisicas">Este campo é requerido.</label>`)
                return false;
            }
            else{
                if(element.parentElement.children[3])
                {
                    element.parentElement.children[3].remove()
                }
                return true;
            }
        },"Este campo é requerido")
    }

    selectpickerValidation2()
    {
        jQuery.validator.addMethod("selectpick", (value,element,params) => {
            if(value.length == 0)
            {
                if(document.getElementById("atividadesFisicasModal-error"))
                {
                    document.getElementById("atividadesFisicasModal-error").remove();
                }
                element.parentElement.childNodes[1].insertAdjacentHTML("afterEnd",`<label id="atividadesFisicasModal-error" class="error" for="atividadesFisicasModal">Este campo é requerido.</label>`)
                return false;
            }
            else{
                if(document.getElementById("atividadesFisicasModal-error"))
                {
                    document.getElementById("atividadesFisicasModal-error").remove();
                }
                return true;
            }
        },"Este campo é requerido")
    }

    aplicarDesconto(){

        $("#valor").on("change", () => {
            var desconto = parseFloat($("#desconto").val().replace("%","").replace(",","."));
            var valor = parseFloat($("#valor").val().replace(".","").replace(",","."));
            if(desconto > 0)
            {
                var valorDesconto = valor - (valor * (desconto / 100));
                if(!isNaN(valorDesconto))
                {
                    $("#valorDesconto").val(valorDesconto.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDesconto").val("");
                }
            }
            else{
                if(!isNaN(valor))
                {
                    $("#valorDesconto").val(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDesconto").val("");
                }
            }
        })

        $("#valorModal").on("change", () => {
            var desconto = parseFloat($("#descontoModal").val().replace("%","").replace(",","."));
            var valor = parseFloat($("#valorModal").val().replace(".","").replace(",","."));
            if(desconto > 0)
            {
                var valorDesconto = valor - (valor * (desconto / 100));
                if(!isNaN(valorDesconto))
                {
                    $("#valorDescontoModal").val(valorDesconto.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDescontoModal").val("");
                }
            }
            else{
                if(!isNaN(valor))
                {
                    $("#valorDescontoModal").val(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDescontoModal").val("");
                }
            }
        })

        $("#descontoModal").on("change", () => {
            var desconto = parseFloat($("#descontoModal").val().replace("%","").replace(",","."));
            var valor = parseFloat($("#valorModal").val().replace(".","").replace(",","."));
            if(desconto > 0)
            {
                var valorDesconto = valor - (valor * (desconto / 100));
                if(!isNaN(valorDesconto))
                {
                    $("#valorDescontoModal").val(valorDesconto.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDescontoModal").val("");
                }
            }
            else{
                if(!isNaN(valor))
                {
                    $("#valorDescontoModal").val(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDescontoModal").val("");
                }
            }
        })

        $("#desconto").on("change", () => {
            var desconto = parseFloat($("#desconto").val().replace("%","").replace(",","."));
            var valor = parseFloat($("#valor").val().replace(".","").replace(",","."));
            if(desconto > 0)
            {
                var valorDesconto = valor - (valor * (desconto / 100));
                if(!isNaN(valorDesconto))
                {
                    $("#valorDesconto").val(valorDesconto.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDesconto").val("");
                }
            }
            else{
                if(!isNaN(valor))
                {
                    $("#valorDesconto").val(valor.toLocaleString('pt-br', {minimumFractionDigits: 2}));
                }
                else{
                    $("#valorDesconto").val("");
                }
            }
        })
    }

    mascara()
    {
        $('#desconto').mask('##0,00%', {reverse: true});
        $('#descontoModal').mask('##0,00%', {reverse: true});
        $('#valor').mask("#.##0,00", {reverse: true});
        $('#valorModal').mask("#.##0,00", {reverse: true});
        $('#valorDesconto').mask("#.##0,00", {reverse: true});
        $('#valorDescontoModal').mask("#.##0,00", {reverse: true});
    }

    obterAtividadesFisicas(padrao = [],selector = "#atividadesFisicas")
    {
        $.ajax({
            url: "/Gerenciar/AtividadeFisica/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    var options = '';
                    res.resultSet.forEach(item => {
                        options += `<option value="${item.idAtividadeFisica}"${padrao.includes(item.idAtividadeFisica) ? "selected" : ""}>${item.descricao}</option>`
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
            title: 'Confirmar Exclusão?',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Excluir',
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if(res.isConfirmed)
            {
                var dados = resultSet[index];
                $.ajax({
                    url : "/Planos/Excluir",
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
                            _planos.obterListaPlanos();
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

    abrirModalEditar(index)
    {
        this.obterAtividadesFisicas(resultSet[index].idAtividadesFisicas,"#atividadesFisicasModal");
        $("#descricaoModal").val(resultSet[index].descricao);
        $("#idPlanoModal").val(resultSet[index].idPlano);
        $("#valorModal").val(parseFloat(resultSet[index].valorPadrao).toLocaleString('pt-br', {minimumFractionDigits: 2}));
        $("#tipoPlanoModal").val(resultSet[index].tipoPlano);
        $("#descontoModal").val(resultSet[index].percentualDesconto);
        $("#valorDescontoModal").val(parseFloat(resultSet[index].valorComDesconto).toLocaleString('pt-br', {minimumFractionDigits: 2}));
        $("#modalPlano").modal("show");
        $("#botaoSalvar").on("click", () => {
            $("#formPlanoModal").validate({
                rules: {
                    atividadesFisicasModal:
                        {
                            selectpick: true
                        }
                },
                submitHandler: (form) => {
                    $.ajax({
                        url: "/Planos/Atualizar",
                        type: "POST",
                        data: transForm.serialize(form),
                        success: (res) => {
                            Swal.fire({
                                title: res.message,
                                icon: res.icon
                            })
                            if(res.status)
                            {
                                $("#modalPlano").modal("hide");
                                table.destroy();
                                _planos.obterListaPlanos();
                            }
                        },
                        error: (err) => {
                            console.log(err);
                        }
                    })
                }
            })
        })
    }

    limparCampos()
    {
        $("#descricao").val("");
        $("#atividadesFisicas").val("");
        $("#atividadesFisicas").selectpicker("refresh");
        $("#valor").val("");
        $("#tipoPlano").val(1);
        $("#desconto").val("0%");
        $("#valorDesconto").val("");
    }

    cadastrar()
    {

        $("#formPlanos").validate({
            rules: {
                atividadesFisicas: {
                    selectpicker: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "/Planos/Gravar",
                    type: "POST",
                    data: transForm.serialize(form),
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){
                            _planos.limparCampos();
                            table.destroy();
                            _planos.obterListaPlanos();
                        }
                    },
                    error: (res) => {
                        console.log(res);
                    }
                })
            }
        });
    }
}

var _planos;
var table;
var resultSet;

$(document).ready(() => {
    _planos = new Planos();
})