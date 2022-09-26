class Exercicio {
    constructor() {
        this.obterListaExerciciosFisicos();
        this.atualizarSelect();
        this.modalObterAlunos();
    }

    atualizarSelect()
    {
        this.obterExerciciosFisicos();
        this.obterGruposMusculares();
    }

    modalObterAlunos()
    {
        $('#modalRelatorioExercicio').on('show.bs.modal', function (e) {
            $.ajax({
                url: "/Gerenciar/ExercicioFisico/obterAlunos",
                type: "GET",
                success: (res) => {
                    if(res.status && res?.resultSet?.length)
                    {
                        var options = "";
                        res.resultSet.forEach((item) => {
                            options += `<option value="${item.idAluno}">${item.nome}</option>`;
                        })
                        $("#relAluno").html(options);
                        $("#relAluno").selectpicker('refresh');
                    }
                    else{
                        Swal.fire({
                            title: "Nenhum aluno possui exercício físico cadastrado.",
                            icon : "info"
                        })
                    }
                }
            })
        })
    }


    async cadastrarGrupoMuscular()
    {
        const { value: grupomuscular } = await Swal.fire({
            title: 'Grupo Muscular',
            input: 'text',
            inputLabel: 'Digite a descricao do grupo muscular',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Cadastrar",
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#dc3545",
            inputValidator: (value) => {
                if (!value) {
                    return 'Voce precisa digitar a descricao!'
                }
            }
        })

        if (grupomuscular) {
            $.post("/Gerenciar/ExercicioFisico/CadastrarGrupoMuscular", {descricao : grupomuscular} )
                .done((res)=> {
                    if(res.status)
                    {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        this.atualizarSelect();
                    }else {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    }
                });
        }
    }

    async cadastrarExercicio()
    {
        const { value: exercicio } = await Swal.fire({
            title: 'Exercicio',
            input: 'text',
            inputLabel: 'Digite a descricao do exercicio',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Cadastrar",
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#dc3545",
            inputValidator: (value) => {
                if (!value) {
                    return 'Voce precisa digitar a descricao!'
                }
            }
        })

        if (exercicio) {
            $.post("/Gerenciar/ExercicioFisico/CadastrarExercicioFisico", {descricao : exercicio} )
                .done((res)=> {
                    if(res.status)
                    {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        this.atualizarSelect();
                    }else {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    }
                });
        }
    }

    obterExerciciosFisicos(selecionado = null,seletor = "#ExercicioFisico")
    {
        $.get("/Gerenciar/ExercicioFisico/ObterExerciciosFisicos", (res) => {
            if(res.status)
            {
                var html = "";
                res.resultSet.forEach((item,i) => {
                    html += `<option value="${item.idExercicioFisico}" ${selecionado != null && selecionado === item.idExercicioFisico? "selected" : "" }>${item.descricao}</option>`
                })
                $(seletor).html(html);
                $(seletor).selectpicker("destroy");
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

    obterGruposMusculares(selecionado = null,seletor = "#GrupoMuscular") {
        $.get("/Gerenciar/ExercicioFisico/ObterGruposMusculares", (res) => {
            if(res.status)
            {
                var html = "";
                res.resultSet.forEach((item,i) => {
                    html += `<option value="${item.idGrupoMuscular}" ${selecionado != null && selecionado === item.idGrupoMuscular? "selected" : "" }>${item.descricao}</option>`
                })
                $(seletor).html(html);
                $(seletor).selectpicker("destroy");
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

    excluir(idExercicioFisico,idGrupoMuscular)
    {
        Swal.fire({
            icon: 'info',
            title: 'Confirmar Desvincular?',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Excluir',
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if(res.isConfirmed)
            {
                $.ajax({
                    url : "/Gerenciar/ExercicioFisico/Excluir",
                    type: "POST",
                    data: {idExercicioFisico,idGrupoMuscular},
                    success: (res) => {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status)
                        {
                            table.destroy();
                            _exercicio.obterListaExerciciosFisicos();
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
        var params = {
            exercicioFisico : $("#ModalIdExercicioFisico").val(),
            grupoMuscular : $("#ModalIdGrupoMuscular").val(),
        };
        if(this.validarParametros(params))
        {
            $.ajax({
                url: "/Gerenciar/ExercicioFisico/Atualizar",
                type: "POST",
                dataType: "json",
                contentType: "application/json;charset=utf-8",
                data: JSON.stringify(params),
                beforeSend: () => {

                },
                complete: () => {

                },
                success: (res) => {
                    if(res.status){
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        table.destroy();
                        _exercicio.obterListaExerciciosFisicos();
                    }else {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    }
                },
                error: (res) => {
                    console.log(res);
                }
            })
        }
        else{
            if(!params.exercicioFisico)
            {
                $(".obrigatorioModal1").removeClass("d-none");
                setTimeout(() => {
                    $(".obrigatorioModal1").addClass("d-none");
                },3000)
            }
            if(!params.grupoMuscular)
            {
                $(".obrigatorioModal2").removeClass("d-none");
                setTimeout(() => {
                    $(".obrigatorioModal2").addClass("d-none");
                },3000)
            }

        }
    }

    gerarRelatorio()
    {
        $("#formRelatorio").validate({
            submitHandler: function(form) {
                var dados = transForm.serialize(form);
                if(!!relAluno) {
                    var params = `?relAluno=${dados.relAluno}`;
                    window.open("/Gerenciar/ExercicioFisico/Relatorio"+params,"_blank");
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
                        title: "Aluno não selecionado."
                    })
                }
            }
        })
    }

    preencherModal(idExericioFisico,idGrupoMuscular)
    {
        $("#ModalIdExercicioFisico").val(idExericioFisico);
        this.obterExerciciosFisicos(idExericioFisico,"#ModalIdExercicioFisico");
        $("#ModalIdGrupoMuscular").val(idGrupoMuscular);
        this.obterGruposMusculares(idGrupoMuscular,"#ModalIdGrupoMuscular");
        $("#botaoSalvar").attr("onclick",`_exercicio.atualizar()`);
    }

    obterListaExerciciosFisicos()
    {
        $.ajax({
            url: "/Gerenciar/ExercicioFisico/ObterTodos",
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
                                        <td>${item.descricaoExercicio}</td>
                                        <td>${item.descricaoGrupo}</td>
                                        <td>
                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modalAluno" onclick="_exercicio.preencherModal('${item.idExercicioFisico}','${item.idGrupoMuscular}')">Alterar</button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="_exercicio.excluir('${item.idExercicioFisico}','${item.idGrupoMuscular}')">Desvincular</button>
                                        </td>
                                 </tr>`
                    })
                    $("#tbody").html(html);
                    _exercicio.dataTable();
                }else {
                    $("#tbody").html(``)
                    this.dataTable();
                }
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


    validarParametros(params)
    {
        var vazios = 0;
        if(params.exercicioFisico == undefined || params.exercicioFisico == null || params.exercicioFisico == "")
            vazios++;
        if(params.grupoMuscular == undefined || params.grupoMuscular == null || params.grupoMuscular == "")
            vazios++;
        return vazios === 0;
    }

    cadastrar()
    {
        var params = {
            exercicioFisico: $("#ExercicioFisico").val(),
            grupoMuscular: $("#GrupoMuscular").val()
        }

        if(!!params.exercicioFisico && !!params.grupoMuscular)
        {
            $.ajax({
                url: "/Gerenciar/ExercicioFisico/Gravar",
                type: "POST",
                dataType: "json",
                contentType: "application/json;charset=utf-8",
                data: JSON.stringify(params),
                beforeSend: () => {

                },
                complete: () => {

                },
                success: (res) => {
                    if(res.status){
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        table.destroy();
                        _exercicio.obterListaExerciciosFisicos();
                    }else {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                    }
                },
                error: (res) => {
                    console.log(res);
                }
            })
        }
        else{
            if(!params.exercicioFisico)
            {
                $(".obrigatorio1").removeClass("d-none");
                setTimeout(() => {
                    $(".obrigatorio1").addClass("d-none");
                },3000)
            }
            if(!params.grupoMuscular)
            {
                $(".obrigatorio2").removeClass("d-none");
                setTimeout(() => {
                    $(".obrigatorio2").addClass("d-none");
                },3000)
            }
        }
    }
}

var _exercicio;
var table;

$(document).ready(() => {
    _exercicio = new Exercicio();
})