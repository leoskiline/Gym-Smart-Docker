class Contrato {
    constructor() {
        this.obterAlunos();
        this.obterFormasPagamento();
        this.obterListaPlanos();
        this.detalharPlanos();
        this.preencherDatas();
        this.selectpickerValidation1();
        this.selectpickerValidation2();
        this.obterContratos();
        this.dataInicialListener();
    }

    dataInicialListener()
    {
        $("#dataInicial").on("change", (e) => {
           var plano = document.getElementById("plano")[document.getElementById("plano").selectedIndex].dataset.tipoplano;
            var dataInicialElem = e.currentTarget;
            var dataFinalElem = document.getElementById("dataFinal");
            var dataInicial = moment(dataInicialElem.value).format("YYYY-MM-DD");
            var dataFinal = moment(dataInicialElem.value).add(parseInt(plano),"months").format("YYYY-MM-DD")
            dataInicialElem.value = dataInicial;
            dataFinalElem.value = dataFinal;
        })
    }

    preencherDatas()
    {
        var mom = new moment()
        $("#dataContrato").val(mom.format("Y-MM-DD"));
        $("#dataInicial").val(mom.format("Y-MM-DD"));
        $("#dataFinal").val(mom.add("1","years").format("Y-MM-DD"));
        $("#diaPagamento").val(10);
    }

    selectpickerValidation1()
    {
        jQuery.validator.addMethod("selectpicker1", (value,element,params) => {
            if(!value)
            {
                if(element.parentElement.children[3])
                {
                    element.parentElement.children[3].remove()
                }
                element.parentElement.childNodes[2].insertAdjacentHTML("afterEnd",`<label id="aluno-error" class="error" for="aluno">Este campo é requerido.</label>`)
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
        jQuery.validator.addMethod("selectpicker2", (value,element,params) => {
            if(!value)
            {
                if(element.parentElement.children[3])
                {
                    element.parentElement.children[3].remove()
                }
                element.parentElement.childNodes[2].insertAdjacentHTML("afterEnd",`<label id="plano-error" class="error" for="plano">Este campo é requerido.</label>`)
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
    cancelar(idContrato)
    {

        Swal.fire({
            icon: 'info',
            title: 'Este cancelamento gerará o pagamento da proxima mensalidade e cancelamento das demais caso o tempo de contrato seja superior à 1 mês. Confirmar Cancelamento?',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545'
        }).then((res) => {
            if(res.isConfirmed)
            {
                var dados = {idContrato};
                $.ajax({
                    url : "/Contrato/Cancelar",
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
                            _contrato.obterContratos();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    atividadesFisicas(atividades)
    {
        var text = "";
        if(atividades)
        {
            atividades.forEach((item,index) => {
                text += `${item},`;
            })
        }
        text = text.substring(0,text.length-1);
        return text;
    }

    dataDeAcordoComPeriodo(plano)
    {
        var dataInicialElem = document.getElementById("dataInicial");
        var dataFinalElem = document.getElementById("dataFinal");
        var dataInicial = moment(dataInicialElem.value).format("YYYY-MM-DD");
        var dataFinal = moment(dataInicialElem.value).add(parseInt(plano),"months").format("YYYY-MM-DD")
        dataInicialElem.value = dataInicial;
        dataFinalElem.value = dataFinal;
    }

    detalharPlanos() {
        $("#plano").on("change", (evt) => {
            var detalhesPlano = planos[evt.currentTarget.selectedIndex];
            this.dataDeAcordoComPeriodo(detalhesPlano.tipoPlano)
            Swal.fire({
                html: `<div class="row col-12">
                            <div class="col-12"><h3><strong>DETALHES DO PLANO</strong></h3></div>
                            <div class="col-12 text-left">
                                <strong>Descrição:</strong> ${detalhesPlano.descricao}
                            </div>
                            <div class="col-12 text-left">
                                <strong>Atividades Físicas:</strong> ${this.atividadesFisicas(detalhesPlano.atividadesFisicas)}
                            </div>
                            <div class="col-12 text-left">
                                <strong>Tipo do Plano:</strong> ${this.obterTipoPlano(detalhesPlano.tipoPlano)}
                            </div>
                            <div class="col-12 text-left">
                                <strong>Valor Padrão:</strong> ${parseFloat(detalhesPlano.valorPadrao).toLocaleString('pt-br', {minimumFractionDigits: 2})}
                            </div>
                            <div class="col-12 text-left">
                                <strong>Desconto:</strong> ${detalhesPlano.percentualDesconto};
                            </div>
                            <div class="col-12 text-left">
                                <strong>Valor com Desconto:</strong> ${parseFloat(detalhesPlano.valorComDesconto).toLocaleString('pt-br', {minimumFractionDigits: 2})}
                            </div>
                        </div>`
                ,
                confirmButtonColor: "#007bff",
                confirmButtonText: "Fechar"
            })
        });
    }


    obterFormasPagamento(selector = '#formasPagamento',padrao = []){
        $.ajax({
            url: "/Contrato/FormasPagamento",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    formasPagamento = res.resultSet;
                    var options = '';
                    res.resultSet.forEach(item => {
                        options += `<option value="${item.idFormaPagamento}"${padrao.includes(item.idFormaPagamento) ? "selected" : ""}>${item.descricao} </option>`
                    })
                    $(selector).html(options);
                }
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    obterFormasPagamentoMensalidade(padrao = []){
        var options = '';
        formasPagamento.forEach(item => {
            options += `<option value="${item.idFormaPagamento}"${padrao.includes(item.idFormaPagamento) ? "selected" : ""}>${item.descricao} </option>`
        })
        return `<select class="form-control">${options}</select>`
    }

    obterListaPlanos(selector = '#plano',padrao = []){
        $.ajax({
            url: "/Planos/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    planos = res.resultSet;
                    var options = '';
                    res.resultSet.forEach(item => {
                        options += `<option value="${item.idPlano}"${padrao.includes(item.idPlano) ? "selected" : ""} data-tipoPlano="${item.tipoPlano}">${item.descricao} - R$: ${parseFloat(item.valorComDesconto).toLocaleString('pt-br', {minimumFractionDigits: 2})} - (${this.atividadesFisicas(item.atividadesFisicas)}) - ${this.obterTipoPlano(item.tipoPlano)}</option>`
                    })
                    $(selector).html(options);
                    $(selector).selectpicker("refresh");
                    var plano = document.getElementById("plano")[document.getElementById("plano").selectedIndex].dataset.tipoplano;
                    var dataInicialElem = document.getElementById("dataInicial");
                    var dataFinalElem = document.getElementById("dataFinal");
                    var dataInicial = moment(dataInicialElem.value).format("YYYY-MM-DD");
                    var dataFinal = moment(dataInicialElem.value).add(parseInt(plano),"months").format("YYYY-MM-DD")
                    dataInicialElem.value = dataInicial;
                    dataFinalElem.value = dataFinal;
                }
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    informarPagamento(idMensalidade,btn,idContrato,index)
    {
        var idFormaPagamento = btn.parentElement.parentElement.childNodes[5].childNodes[0].value
        $.ajax({
            url: "/Contrato/VerificarMensalidadeCronologica",
            type: "POST",
            data: {idMensalidade},
            success: (res) => {
                if(res.status)
                {
                    Swal.fire({
                        icon: 'info',
                        title: 'Existem mensalidades anteriores pendentes, deseja confirmar pagamento desta mensalidade mesmo assim?',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Conrfimar',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#dc3545'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            $.ajax({
                                url: "/Contrato/PagamentoMensalidade",
                                type: "POST",
                                data: {idMensalidade,idFormaPagamento,idContrato},
                                success: (res) => {
                                    if(res.status)
                                    {
                                        this.visualizarMensalidades(index);
                                    }
                                },
                                error: (err) => {
                                    console.log(err);
                                }
                            })
                        }
                    })
                }
                else{
                    Swal.fire({
                        icon: 'info',
                        title: 'Confirmar Pagamento da Mensalidade na Data de Hoje?',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Conrfimar',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#dc3545'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            $.ajax({
                                url: "/Contrato/PagamentoMensalidade",
                                type: "POST",
                                data: {idMensalidade,idFormaPagamento,idContrato},
                                success: (res) => {
                                    if(res.status)
                                    {
                                        this.visualizarMensalidades(index);
                                    }
                                },
                                error: (err) => {
                                    console.log(err);
                                }
                            })
                        }
                    })
                }
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    estornarMensalidade(idMensalidade,index)
    {
        Swal.fire({
            icon: "info",
            title: "Deseja confirmar estorno?",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if (res.isConfirmed) {
                var dados = {idMensalidade};
                $.ajax({
                    url: "/Contrato/EstornoMensalidade",
                    type: "POST",
                    data: dados,
                    success: (res) => {
                        if(res.status)
                        {
                            this.visualizarMensalidades(index)
                        }
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        });
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    informarPagamentoButton(item,index)
    {
        var ret = `<button class="btn btn-success" disabled style="opacity: 1">PAGAMENTO EFETUADO</button>`
        if(!item.contrato.dataCancelamento)
        {
            ret += `<button class="btn btn-primary ml-1" onclick="_contrato.estornarMensalidade(${item.idMensalidade},${index})">ESTORNAR</button>`
        }
        if(!item.dataPagamento)
        {
            ret = `<button class="btn btn-outline-success" onclick="_contrato.informarPagamento(${item.idMensalidade},this,${item.contrato.idContrato},${index})">INFORMAR PAGAMENTO</button>`
        }
        if(item.formaPagamento.pagamentoAutomatico == "1")
        {
            ret = `<button class="btn btn-success" disabled style="opacity: .65">PAGAMENTO AUTOMATICO</button>`
        }
        if(item.mensalidadeCancelada == "1")
        {
            ret = `<button class="btn btn-danger" disabled style="opacity: 1">MENSALIDADE CANCELADA</button>`
        }
        return ret;
    }

    visualizarMensalidades(index)
    {
        var dados = resultSet[index];
        $.ajax({
            url : "/Contrato/ObterMensalidades",
            type: "POST",
            data: dados,
            success: (res) => {
                if(res && res.resultSet)
                {
                    var html = "";
                    res.resultSet.forEach((item) => {
                        var fp = _contrato.obterFormasPagamentoMensalidade(item.formaPagamento.idFormaPagamento);
                        html += `<tr>
                                    <td>${item.contrato.aluno.nome}</td>
                                    <td>${!!item.valor ? parseFloat(item.valor).toLocaleString('pt-br', {minimumFractionDigits: 2}) : ""}</td>
                                    <td>${fp}</td>
                                    <td>${item.dataMensalidade < moment().format("YYYY-MM-DD") && item.dataPagamento == null ? '<span class="text-danger">'+item.dataMensalidade.substr(0, 10).split('-').reverse().join('/')+'</span>' : item.dataMensalidade.substr(0, 10).split('-').reverse().join('/')}</td>
                                    <td>${!!item.dataPagamento ? item.dataPagamento.substr(0, 10).split('-').reverse().join('/') : ""}</td>
                                    <td>${this.informarPagamentoButton(item,index)}</td>
                                </tr>`
                    })
                    if(tableMensalidades)
                    {
                        tableMensalidades.destroy();
                    }
                    $("#tbodyMensalidade").html(html);

                    this.dataTableMensalidades();
                    $("#modalMensalidade").modal("show");
                }else{
                    Swal.fire({
                        title: "Ocorreu um erro ao consultar mensalidades deste contrato",
                        icon: "error"
                    })
                }
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    dataTableMensalidades()
    {
        tableMensalidades = $("#tabelaMensalidades").DataTable({
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
        });
    }

    dataTable()
    {
        table = $("#tableContratos").DataTable({
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

    obterBotaoCancelamento(item)
    {
        var botao = "";
        if(!item.dataCancelamento)
        {
            botao = `<button class="btn btn-sm btn-outline-danger" onclick="_contrato.cancelar('${item.idContrato}')" title="Efetuar Cancelamento do Contrato">Cancelar</button>`;
        }
        return botao;
    }

    async alterarDiaPagamento(index)
    {
        var dados = resultSet[index];
        const { value: diaPagamento } = await Swal.fire({
            title: 'Selecione o novo dia de pagamento',
            input: 'select',
            inputOptions: {
                1 : 1,
                2 : 2,
                3 : 3,
                4 : 4,
                5 : 5,
                6 : 6,
                7 : 7,
                8 : 8,
                9 : 9,
                10 : 10,
                11 : 11,
                12 : 12,
                13 : 13,
                14 : 14,
                15 : 15,
                16 : 16,
                17 : 17,
                18 : 18,
                19 : 19,
                20 : 20,
                21 : 21,
                22 : 22,
                23 : 23,
                24 : 24,
                25 : 25,
                26 : 26,
                27 : 27,
                28 : 28,
            },
            inputPlaceholder: 'Dia',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#dc3545",
            showConfirmButton: true,
            confirmButtonText: "Alterar",
            confirmButtonColor: "#28a745",
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value != dados.diaPagamento) {
                        resolve()
                    } else {
                        resolve('Você precisa selecionar um dia de pagamento diferente do atual.')
                    }
                })
            }
        })

        if (diaPagamento) {
            dados.diaPagamento = diaPagamento;
            $.ajax({
                url: "/Contrato/AlterarDiaPagamento",
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
                        _contrato.obterContratos();
                    }
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }
    }

    obterBotaoAlterarDiaPagamento(item,index)
    {
        var botao = "";
        if(!item.dataCancelamento)
        {
            botao = `<button class="btn btn-sm btn-outline-primary mr-1" onclick="_contrato.alterarDiaPagamento('${index}')" title="Alterar Dia de Pagamento">Dia de Pagamento</button>`;
        }
        return botao;
    }

    obterContratos()
    {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        let value = params.atraso;
        var endPoint = "/Contrato/ObterTodos";
        if(!!value)
        {
            endPoint += "?atraso="+value;
        }
        $.ajax({
            url: endPoint,
            type: "GET",
            success: (res) => {
                if(res)
                {
                    var html = "";
                    resultSet = res;
                    res.forEach((item,index) => {
                        html += `<tr>
                                    <td class="text-center">${item.idContrato.padStart(6,"0")}</td>
                                    <td>${item.aluno.nome}</td>
                                    <td><a href="javascript:void(0)" data-toggle="popover" title="Atividades Físicas" data-content="${item.plano.atividadesFisicas}">${item.plano.descricao} (${this.obterTipoPlano(item.plano.idTipoPlano)})</a></td>
                                    <td>${moment(item.dataContrato).format("DD/MM/YYYY")}</td>
                                    <td>${moment(item.dataInicio).format("DD/MM/YYYY")}</td>
                                    <td>${moment(item.dataFim).format("DD/MM/YYYY")}</td>
                                    <td class="text-center">${item.dataCancelamento ? "<span class='badge badge-danger text-uppercase'>"+moment(item.dataCancelamento).format("DD/MM/YYYY")+"</span>" : "<span class='badge badge-success text-uppercase'>Plano Ativo</span>"}</td>
                                    <td>R$ ${parseFloat(item.valor).toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                                    <td class="text-center">${item.diaPagamento}</td>
                                    <td class="text-center"><a href="javascript:void(0)" onclick="_contrato.visualizarMensalidades('${index}')"><i class="fa-solid fa-eye"></i> Visualizar</a></td>
                                    <td class="text-center">
                                        ${this.obterBotaoAlterarDiaPagamento(item,index)}
                                        ${this.obterBotaoCancelamento(item)}
                                    </td>
                                </tr>`;
                    })
                    $("#tContratos").html(html);

                    $('#tableContratos').on( 'draw.dt', function () {
                        $('[data-toggle="popover"]').popover({
                            trigger: 'focus'
                        })
                    } );
                }
                this.dataTable();
            },
            error: (err) => {
                console.log(err);
            }
        })
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

    obterAlunos(selector = '#aluno',selected = false)
    {
        $("#loading").addClass("fas fa-sync fa-spin")
        $.ajax({
            url: "/Gerenciar/Aluno/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res && res.resultSet)
                {
                    var options = '';
                    res.resultSet.forEach((item) => {
                        if(item.idAluno == selected)
                        {
                            options += `<option value="${item.idAluno}" selected>${item.nome}</option>`;
                        }else{
                            options += `<option value="${item.idAluno}">${item.nome}</option>`;
                        }
                    })
                    $(selector).html(options);
                    $(selector).selectpicker("refresh");
                }
                $("#loading").removeClass("fas fa-sync fa-spin")
            },
            error: (err) => {
                console.log(err);
                $("#loading").removeClass("fas fa-sync fa-spin")
            }
        })
    }

    abrirModalEditar(index)
    {
        this.obterAtividadesFisicas(resultSet[index].idAtividadesFisicas,"#atividadesFisicasModal");
        $("#descricaoModal").val(resultSet[index].descricao);
        $("#idPlanoModal").val(resultSet[index].idPlano);
        $("#valorModal").val(parseFloat(resultSet[index].valorPadrao).toLocaleString('pt-br', {minimumFractionDigits: 2}));
        $("#descontoModal").val(resultSet[index].percentualDesconto);
        $("#valorDescontoModal").val(parseFloat(resultSet[index].valorComDesconto).toLocaleString('pt-br', {minimumFractionDigits: 2}));
        $("#modalPlano").modal("show");
        $("#botaoSalvar").on("click", () => {
            $("#formPlanoModal").validate({
                rules: {
                    aluno:
                        {
                            selectpicker1: true
                        },
                    plano:
                        {
                            selectpicker2: true
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
                                _contrato.obterContratos();
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
        $("#desconto").val("0%");
        $("#valorDesconto").val("");
    }

    gerarRelatorio()
    {
        $("#formRelatorio").validate({
            submitHandler: function(form) {
                var dados = transForm.serialize(form);
                if(dados.relContratoDataInicial < dados.relContratoDataFinal) {
                    var params = `?dataInicial=${dados.relContratoDataInicial}&dataFinal=${dados.relContratoDataFinal}`;
                    window.open("/Contrato/Relatorio"+params,"_blank");
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

        $("#formContrato").validate({
            rules: {
                aluno:
                    {
                        selectpicker1: true
                    },
                plano:
                    {
                        selectpicker2: true
                    }
            },
            submitHandler: function(form) {
                var dados = transForm.serialize(form);
                if(dados.dataContrato > dados.dataInicial)
                {
                    Swal.fire({
                        icon: "error",
                        title: "Data do Contrato não pode ser maior que data inicial."
                    })
                    return;
                }
                if(dados.dataContrato > dados.dataFinal)
                {
                    Swal.fire({
                        icon: "error",
                        title: "Data do Contrato não pode ser maior que data final."
                    })
                    return;
                }
                if(dados.dataInicial >= dados.dataFinal)
                {
                    Swal.fire({
                        icon: "error",
                        title: "Data inicial não pode ser maior ou igual a data final."
                    })
                    return;
                }
                $.ajax({
                    url: "/Contrato/Gravar",
                    type: "POST",
                    data: dados,
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){
                            table.destroy();
                            _contrato.obterContratos();
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

var _contrato;
var table;
var tableMensalidades;
var resultSet;
var planos;
var formasPagamento;

$(document).ready(() => {
    _contrato = new Contrato();
})