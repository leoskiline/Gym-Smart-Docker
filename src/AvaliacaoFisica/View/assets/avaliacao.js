class Avaliacao {
    constructor() {
        this.obterAgendamentosHoje();
        this.obterAvaliacoesFisicas();
        //this.dataFiltro();
    }

    dataFiltro()
    {
        var hoje = moment().format("YYYY-MM-DD");
        document.getElementById("dataInicio").value = hoje;
        document.getElementById("dataFim").value = hoje;
    }

    abrirDetalhes(index)
    {
        var dados = _resultSet[index];
        var html = `<div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <label for="detalhesNome">Nome do Cliente</label>
                            <p>${dados.title}</p>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <label for="detalhesTipo">Tipo de Avaliação</label>
                            <p>${dados.tipoAvaliacao}</p>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <label for="detalhesValor">Valor</label>
                            <p>${parseFloat(dados.valor).toLocaleString('pt-br', {minimumFractionDigits: 2})}</p>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <label for="detalhesData">Realizada em</label>
                            <p>${new Date(dados.datahoraInicio).toLocaleString()} <b>até</b> ${new Date(dados.datahoraFim).toLocaleString()}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="overflow-y: scroll;max-height: 540px;">
                        <div class="col-12 text-center"><h2>Ficha Técnica</h2></div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalheNivelAptadaoFisica">Nivel de Aptidão Física</label>
                            <textarea class="form-control" readonly>${dados.nivelaptidaofisica}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalheBancoWells">Peso</label>
                            <textarea class="form-control" readonly>${dados.peso}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhedesviopostura">Altura</label>
                            <textarea class="form-control" readonly>${dados.altura}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhedobrascutaneas">Dores</label>
                            <textarea class="form-control" readonly>${dados.dores}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhedores">Histórico Saúde</label>
                            <textarea class="form-control" readonly>${dados.historicosaude}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalheflexibilidades">Desvios e Postura</label>
                            <textarea class="form-control" readonly>${dados.desviospostura}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhemetas">% de Gordura</label>
                            <textarea class="form-control" readonly>${dados.percentualgordura}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhepafc">% de Massa Magra</label>
                            <textarea class="form-control" readonly>${dados.percentualmassamagra}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalheparq">Metas</label>
                            <textarea class="form-control" readonly>${dados.metas}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhepesoaltura">Objetivo</label>
                            <textarea class="form-control" readonly>${dados.objetivo}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhepesoosseo">Habitos Alimentares</label>
                            <textarea class="form-control" readonly>${dados.habitosalimentares}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalherepeticaomaxima">Qualidade do Sono</label>
                            <textarea class="form-control" readonly>${dados.qualidadesono}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalheresistenciamuscular">Bebida Alcoólica</label>
                            <textarea class="form-control" readonly>${dados.bebidaalcoolica}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhevo2">Fumante</label>
                            <textarea class="form-control" readonly>${dados.fumante}</textarea>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="detalhevo2">Medicamentos</label>
                            <textarea class="form-control" readonly>${dados.medicamentos}</textarea>
                        </div>
                    </div>`;
        $("#modalDetalhesBody").html(html);
        $("#modalDetalhes").modal("show");
    }

    obterAvaliacoesFisicas(dataInicial = null,dataFinal = null)
    {
        var params = "";
        if(dataInicial && !dataFinal)
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
                icon: "error",
                title: "Voce precisa selecionar a data final."
            })
            return;
        }
        if(!dataInicial && dataFinal)
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
                icon: "error",
                title: "Você precisa selecionar a data inicial."
            })
            return;
        }
        if(!!dataInicial && !!dataFinal)
        {
            if(dataInicial > dataFinal)
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
                    icon: "error",
                    title: "Data inicial nao pode ser maior que data final."
                })
                return;
            }else{
                params = `?dataInicial=${dataInicial}&dataFinal=${dataFinal}`;
            }
        }
        $.ajax({
            url: "/Gerenciar/AvaliacaoFisica/ObterTodos"+params,
            type: "GET",
            success: (res) => {
                var html = "";
                if(res.status)
                {
                    _resultSet = res.resultSet;
                    res.resultSet.forEach((item,index) => {
                        html += `
                                    <tr>
                                        <td>${item.idAvaliacaoFisica}</td>
                                        <td>${item.title}</td>
                                        <td>${item.tipoAvaliacao}</td>
                                        <td>${parseFloat(item.valor).toLocaleString('pt-br', {minimumFractionDigits: 2})}</td>
                                        <td>${new Date(item.datahoraInicio).toLocaleDateString()}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="_avaliacao.abrirDetalhes(${index})">Detalhes</button>
                                            <a type="button" class="btn btn-secondary" href="/Gerenciar/AvaliacaoFisica/GerarPDF?idAvaliacaoFisica=${item.idAvaliacaoFisica}" target="_blank">Gerar PDF</a>
                                        </td>
                                    </tr>
                                `;
                    });
                }
                if(_table)
                    _table.destroy();
                $("#listaAvaliacoes").html(html);
                this.dataTable();
            },
            error: (err) => {
                console.log(err);
            }
        })
    }

    dataTable()
    {
        _table = $("#tabelaAvaliacoes").DataTable({
            aaSorting: [],
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

    validarCampos(valores)
    {
        var camposPreenchidos = 0;
        if(!!valores.nivelaptidaofisica)
        {
            camposPreenchidos++;
        }
        if(!!valores.peso)
        {
            camposPreenchidos++;
        }
        if(!!valores.altura)
        {
            camposPreenchidos++;
        }
        if(!!valores.dores)
        {
            camposPreenchidos++;
        }
        if(!!valores.historicosaude)
        {
            camposPreenchidos++;
        }
        if(!!valores.desviospostura)
        {
            camposPreenchidos++;
        }
        if(!!valores.percentualgordura)
        {
            camposPreenchidos++;
        }
        if(!!valores.percentualmassamagra)
        {
            camposPreenchidos++;
        }
        if(!!valores.metas)
        {
            camposPreenchidos++;
        }
        if(!!valores.objetivo)
        {
            camposPreenchidos++;
        }
        if(!!valores.habitosalimentares)
        {
            camposPreenchidos++;
        }
        if(!!valores.qualidadesono)
        {
            camposPreenchidos++;
        }
        if(!!valores.bebidaalcoolica)
        {
            camposPreenchidos++;
        }
        if(!!valores.fumante)
        {
            camposPreenchidos++;
        }
        if(!!valores.medicamentos)
        {
            camposPreenchidos++;
        }
        return camposPreenchidos;
    }

    limparCampos()
    {
        $("#nivelaptidaofisica").val("");
        $("#agendamentoAvaliacao").val("");
        $("#agendamentoAvaliacao").selectpicker('refresh');
        $("#peso").val("");
        $("#altura").val("");
        $("#dores").val("");
        $("#historicosaude").val("");
        $("#desviospostura").val("");
        $("#percentualgordura").val("");
        $("#percentualmassamagra").val("");
        $("#metas").val("");
        $("#objetivo").val("");
        $("#habitosalimentares").val("");
        $("#qualidadesono").val("");
        $("#bebidaalcoolica").val("");
        $("#fumante").val("");
        $("#medicamentos").val("");
    }

    salvar()
    {
        var frm = document.getElementById("avaliacaoFisica");
        var dados = transForm.serialize(frm);
        if(this.validarCampos(dados) >= 3)
        {
            if(!!dados.agendamentoAvaliacao)
            {
                $.ajax({
                    url:"/Gerenciar/AvaliacaoFisica/Salvar",
                    type: "POST",
                    data: dados,
                    success: (res) => {
                        if(res.status)
                        {
                            this.limparCampos();
                            this.obterAgendamentosHoje();
                            this.obterAvaliacoesFisicas();
                        }
                        Swal.fire(res.message,'',res.icon);
                    },
                    error: (err) => {
                        console.log(err);
                    }
                })
            }else{
                Swal.fire('Você não selecionou o aluno agendado.','','info');
            }

        }else{
            Swal.fire('Você precisa preencher ao menos 3 campos.','','info');
        }
    }

    obterAgendamentosHoje()
    {
        $.ajax({
            url: "/Gerenciar/AvaliacaoFisica/ObterAgendamentosHoje",
            type: "GET",
            success: (res) => {
                var options = "<option value=''>Nenhum agendamento selecionado</option>";
                if(res.status)
                {

                    res.resultSet.forEach((item) => {
                        options += `<option value="${item.idAgendamentoAvaliacaoFisica}">
                                    Aluno: ${item.title} |
                                    Valor: R$ ${parseFloat(item.valor).toLocaleString('pt-br', {minimumFractionDigits: 2})} |
                                    Tipo:   ${item.tipoAvaliacao} |
                                    Horário: de ${new Date(item.start).toLocaleTimeString()} até ${new Date(item.end).toLocaleTimeString()}</option>`
                    })
                }else{
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
                        icon: "info",
                        title: "Nenhum agendamento na data de hoje"
                    })
                }
                $("#agendamentoAvaliacao").html(options);
                $("#agendamentoAvaliacao").selectpicker("refresh");
            },
            error: (err) => {
                console.log(err);
            }
        })
    }
}

var _avaliacao;
var _table;
var _resultSet;

$(document).ready(() => {
    _avaliacao = new Avaliacao();
})