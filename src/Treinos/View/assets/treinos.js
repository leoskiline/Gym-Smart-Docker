class Treinos {
    listaExercicios
    exerciciosAdicionados = []
    constructor() {
        this.obterAlunos();
        this.eventListenerAlunos();
        this.obterGruposMusculares();
        this.eventListenerGrupoMuscular();
        $('#peso').mask('000.000.000.000.000 KG', {reverse: true});
        $('#series').mask('0000', {reverse: true});
        $('#repeticoes').mask('0000', {reverse: true});
        this.tagsExercicios()
        this.validarTags();
        this.selectpickerValidation();
        this.obterListaTreinos();
    }

    eventListenerAlunos()
    {
        $("#aluno").on("change", (evt) => {
            var valor = evt.currentTarget.value;
            if(!!valor)
            {
                $.ajax({
                    url:'/Treinos/ObterAvaliacaoFisicaPorContrato',
                    type: 'GET',
                    data: { idContrato: valor },
                    success: (res) => {
                        if(res.status && res.resultSet)
                        {
                            let data = new Date(res.resultSet.inicio).toLocaleDateString();
                            $("#avaliacaoFisica").html(`<option value="${res.resultSet.idAvaliacaoFisica}">${res.resultSet.nome} - ${res.resultSet.tipo} (${data})</option>`)
                            $("#avaliacaoFisica").selectpicker("refresh");
                        }
                        else{
                            $("#avaliacaoFisica").html(`<option value="">Não possui Avaliação Física</option>`)
                            $("#avaliacaoFisica").selectpicker("refresh");
                        }
                    },
                    else: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    validarTags()
    {
        this.listaExercicios.on("add", (e) => {
            this.exerciciosAdicionados.push(parseInt(e.detail.data.exercicio));
            this.obterExerciciosPorGrupoMuscular();
        })

        this.listaExercicios.on("remove", (e) => {
            const index = this.exerciciosAdicionados.indexOf(parseInt(e.detail.data.exercicio));
            if(index > -1)
            {
                this.exerciciosAdicionados.splice(index,1);
                this.obterExerciciosPorGrupoMuscular();
            }
        })
    }

    adicionarExercicios()
    {
        var grupoMuscularElem = document.getElementById("grupoMuscular");
        var exercicioFisicoElem = document.getElementById("exercicioFisico");
        var seriesElem = document.getElementById("series");
        var repeticoesElem = document.getElementById("repeticoes");
        var pesoSugeridoElem = document.getElementById("peso");
        var diaExercicioElem = document.getElementById("diaExercicio");
        if(grupoMuscularElem.selectedOptions[0].value && exercicioFisicoElem.selectedOptions[0].value && seriesElem.value && repeticoesElem.value && pesoSugeridoElem.value && diaExercicioElem.selectedOptions.length)
        {
            var obj = [{
                value: grupoMuscularElem.selectedOptions[0].innerHTML+" - "+exercicioFisicoElem.selectedOptions[0].innerHTML+" - "+seriesElem.value+"S - "+repeticoesElem.value+"R - "+pesoSugeridoElem.value+" - "+diaExercicioElem.selectedOptions[0].innerHTML,
                grupo: grupoMuscularElem.value,
                exercicio: exercicioFisicoElem.value,
                series: seriesElem.value,
                repeticoes: repeticoesElem.value,
                pesoSugerido: pesoSugeridoElem.value,
                diaExercicio: diaExercicioElem.value
            }];
            this.listaExercicios.addTags(obj)
        }
    }

    tagsExercicios()
    {
        var listaExerciciosElem = document.getElementById("listaExercicios");
        this.listaExercicios = new Tagify (listaExerciciosElem,{
            editTags: false
        });
    }

    obterExerciciosPorGrupoMuscular()
    {
        $.ajax({
            url: "/Treinos/ExerciciosPorGrupoMuscular",
            type: "POST",
            data: {
                "idGrupoMuscular": document.getElementById("grupoMuscular").value,
                "NaoListar" : this.exerciciosAdicionados
            },
            success: (res) => {
                var exerciciosFisicos = "<option value=''>Nenhum</option>";
                if(res.status)
                {
                    if(res.resultSet)
                    {

                        res.resultSet.forEach((item) => {
                            exerciciosFisicos += `<option value="${item.idExercicioFisico}">${item.descricao}</option>`
                        })

                    }
                }else{
                    Swal.fire({
                        title: res.message,
                        icon: res.icon
                    })
                }
                $("#exercicioFisico").html(exerciciosFisicos);
                $("#exercicioFisico").selectpicker("refresh")
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    eventListenerGrupoMuscular()
    {
        $("#grupoMuscular").on("change", (evt) => {
            this.obterExerciciosPorGrupoMuscular();
        })

        $("#aluno").on("change", (evt) => {
            this.exerciciosAdicionados = [];
            if(!!document.getElementById("grupoMuscular").value)
                this.obterExerciciosPorGrupoMuscular();
            this.listaExercicios.removeAllTags();
        })
    }

    obterGruposMusculares(selecionado = null,seletor = "#grupoMuscular") {
        $.get("/Gerenciar/ExercicioFisico/ObterGruposMusculares", (res) => {
            var html = "<option value=''>Nenhum</option>";
            if(res.status)
            {
                var html = "<option value=''>Selecione um Grupo Muscular</option>";
                res.resultSet.forEach((item,i) => {
                    html += `<option value="${item.idGrupoMuscular}" ${selecionado != null && selecionado === item.idGrupoMuscular? "selected" : "" }>${item.descricao}</option>`
                })
                $(seletor).html(html);
                $(seletor).selectpicker("refresh");
                $(seletor).selectpicker({
                    liveSearch : true,
                    width: '100%'
                });
            }else{
                Swal.fire({
                    title: res.message,
                    icon: res.icon
                })
            }
        })
    }

    obterAlunos(selector = '#aluno',selected = false)
    {
        $("#loading").addClass("fas fa-sync fa-spin")
        $.ajax({
            url: "/Treinos/ObterAlunosContrato",
            type: "GET",
            success: (res) => {
                if(res && res.resultSet)
                {
                    var options = '<option value="">Selecione um Aluno</option>';
                    res.resultSet.forEach((item) => {
                        if(item.idAluno == selected)
                        {
                            options += `<option value="${item.idContrato}" selected>${item.idAluno.nome} [${item.idContrato.padStart(6,"0")}]</option>`;
                        }else{
                            options += `<option value="${item.idContrato}">${item.idAluno.nome} [${item.idContrato.padStart(6,"0")}]</option>`;
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

    selectpickerValidation()
    {
        jQuery.validator.addMethod("selectpicker", (value,element,params) => {
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

        jQuery.validator.addMethod("validarListaExercicios", (value,element,params) => {
            if(this.listaExercicios.value.length >= 3)
            {
                return true;
            }else{
                return false;
            }
        },"Adicione ao menos 3 exercicios fisicos na lista de exercicios.")
    }

    obterAtividades(atv)
    {
        var html = ``;
        atv.forEach((item) => {
            html += `<span class="d-block">${item}</span>`
        })
        return html;
    }

    obterTreinador(item)
    {
        var treinador = "";
        if(!!item.idAdministrador)
        {
            treinador = `${item.nomeAdministrador} (Administrador)`;
        }
        else if(!!item.idInstrutor)
        {
            treinador = `${item.nomeInstrutor} (Instrutor)`;
        }
        return treinador;
    }

    abrirDetalhes(index)
    {
        Global.info = resultSet[index];
        $.ajax({
            url: "/Treinos/obterExercicios",
            type: "GET",
            data: {idTreino : Global.info.idTreino},
            success: (res) => {
                if(tableDetalhes)
                    tableDetalhes.destroy();
                if(res.status && res.resultSet)
                {
                    var trows = "";
                    res.resultSet.forEach((item) => {
                        trows += `<tr>
                                        <td>${item.dia}</td>
                                        <td>${item.grupomuscular}</td>
                                        <td>${item.exerciciofisico}</td>
                                        <td>${item.series}</td>
                                        <td>${item.repeticoes}</td>
                                        <td>${item.peso}</td>
                                    </tr>`
                    })
                    var info = Global.info;
                    var infoAluno = `<div class="col-12"><h3 class="text-center">Informações do Aluno</h3></div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label>Aluno:</label>
                                        <p>${info.nomeCliente}</p>
                                     </div>
                                     <div class="col-lg-4 col-sm-12">
                                        <label>Treinador</label>
                                        <p>${!!info.nomeAdministrador ? info.nomeAdministrador : info.nomeInstrutor}</p>
                                     </div>
                                     <div class="col-lg-4 col-sm-12">
                                        <label>Data do Treino</label>
                                        <p>${info.dataInicio} até ${info.dataFim}</p>
                                     </div>
                                     <hr class="w-100">
                                `;
                    $("#infoAluno").html(infoAluno);
                    $("#tbodyModal").html(trows);
                }
                $("#modalTreino").modal("show");
                tableDetalhes = $("#tabelaModal").DataTable({
                    language: this.dtPTBR(),
                    destroy: true
                });

            },
            error: (err) => {
                console.log(err);
            }
        })

    }

    gerarPDF(index)
    {
        var idTreino = resultSet[index].idTreino;
        window.open("/Treinos/obterPDF?idTreino="+idTreino, '_blank').focus();
    }

    obterListaTreinos(){
        $.ajax({
            url: "/Treinos/ObterTodos",
            type: "GET",
            success: (res) => {
                if(res.status && res.resultSet)
                {
                    var html = ``
                    resultSet = res.resultSet;
                    res.resultSet.forEach((item,index) => {
                        let avaliacao = `<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="popover" title="Avaliação Física" data-content="Avaliação física não vinculada ao treino">Não</button>`
                        if(item.idAvaliacaoFisica)
                            avaliacao = `<button type="button" class="btn btn-sm btn-outline-success" data-toggle="popover" title="Avaliação Física" data-content='<b>Tipo:</b>${item.tipoAvaliacao}<br><b>Data:</b>${item.dataAvaliacao}<br><b>Valor:</b>R$ ${item.valorAvaliacao}'>Sim</button>`
                        html += `<tr>
                                    <td>${item.idTreino}</td>
                                    <td>${item.nomeCliente}</td>
                                    <td>${avaliacao}</td>
                                    <td>${item.dataCriacao}</td>
                                    <td>${item.dataInicio}</td>
                                    <td>${item.dataFim}</td>
                                    <td>${_treinos.obterTreinador(item)}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary" onclick="_treinos.abrirDetalhes('${index}')">Visualizar</button>
                                        <button type="button" class="btn btn-outline-secondary ml-2" onclick="_treinos.gerarPDF('${index}')">Gerar PDF</button>
                                    </td>
                                 </tr>`
                    })
                    $("#tbody").html(html);
                    $('[data-toggle="popover"]').popover({
                        trigger: 'focus',
                        html: true
                    })
                    this.dataTable();
                    $('#tabelaTreinos').on( 'draw.dt', function () {
                        $('[data-toggle="popover"]').popover({
                            trigger: 'focus',
                            html: true
                        })
                    } );
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
                            _treinos.obterListaPlanos();
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }
        })
    }

    dtPTBR()
    {
        return {
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
    }

    dataTable()
    {
        table = $("#tabelaTreinos").DataTable({
            language: this.dtPTBR()
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
                                _treinos.obterListaPlanos();
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

    mostrarToast(msg,icon)
    {
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
            icon: icon,
            title: msg
        })
    }

    cadastrar()
    {

        $("#formTreino").validate({
            rules: {
                aluno: {
                    selectpicker: true
                },
                listaExercicios: {
                    validarListaExercicios: true
                }
            },
            submitHandler: function(form) {
                var dados = {
                    contrato: document.getElementById("aluno").value,
                    dataCriacao: moment(document.getElementById("data").value).format("Y-MM-DD HH:mm:ss"),
                    dataInicio: document.getElementById("dataInicio").value,
                    dataFim: document.getElementById("dataFim").value,
                    avaliacaoFisica: document.getElementById("avaliacaoFisica").value,
                    listaExercicios: _treinos.listaExercicios.value
                }
                if(dados.dataCriacao > dados.dataInicio || dados.dataCriacao > dados.dataFim)
                {
                    _treinos.mostrarToast("Data de Criação não pode ser maior que Data de Inicio ou Fim","error");
                    return;
                }
                if(dados.dataFim < dados.dataInicio)
                {
                    _treinos.mostrarToast("Data de Fim não pode ser menor que Data de Inicio","error");
                    return;
                }
                if(dados.dataInicio == dados.dataFim)
                {
                    _treinos.mostrarToast("Data de Inicio não pode ser igual a Data de Fim","error");
                    return;
                }
                $.ajax({
                    url: "/Treinos/Gravar",
                    type: "POST",
                    data: dados,
                    success: (res) => {
                        if(res.message && res.icon)
                        {
                            Swal.fire({
                                title: res.message,
                                icon: res.icon
                            })
                        }
                        if(res.status){
                            _treinos.limparCampos();
                            table.destroy();
                            _treinos.obterListaTreinos();
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

var _treinos;
var table;
var tableDetalhes;
var resultSet;
var gruposSelecionados;

$(document).ready(() => {
    _treinos = new Treinos();
})