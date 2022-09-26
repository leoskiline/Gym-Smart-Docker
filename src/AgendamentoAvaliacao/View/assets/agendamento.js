class Agendamento {
    constructor() {
        this.calendario();
    }

    filtrar()
    {
        this.obterAlunos("#filterAluno");
        this.obterAvaliadores("#filterAvaliador");
        $("#modalFilter").modal("show");
        $("#btnFiltrar").on("click", () => {
            this.calendario(transForm.serialize(document.getElementById("formFilter")));
        })
    }

    calendario(params = null)
    {
        _calendario = new FullCalendar.Calendar(document.getElementById("calendar"),{
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            events: {
                url: '/AgendamentoAvaliacao/Eventos',
                method: 'POST',
                extraParams: params
            },
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            eventClick: function(click) {
                var object = click.event;
                var html = `
                            <div class="col-4">
                                <label for="editAluno">Aluno</label>
                                <input type="hidden" value="${object.extendedProps.idAgendamentoAvaliacaoFisica}" name="idAgendamentoAvaliacaoFisica" id="idAgendamentoAvaliacaoFisica">
                                <select class="form-control selectpicker" data-live-search="true" id="editAluno" name="editAluno"></select>
                            </div>
                            <div class="col-4">
                                <label for="editTipoAvaliacao">Tipo de Avaliação</label>
                                <select id="editTipoAvaliacao" name="editTipoAvaliacao" class="form-control">
                                    <option value="Completa">Completa</option>
                                    <option value="Parcial">Parcial</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="editAvaliador">Avaliador</label>
                                <select id="editAvaliador" name="editAvaliador" class="form-control selectpicker" data-live-search="true"></select>
                            </div>
                            <div class="col-4">
                                <label for="editInicio">Inicio da Avaliação</label>
                                <input type="datetime-local" class="form-control" id="editInicio" name="editInicio">
                            </div>
                            <div class="col-4">
                                <label for="editFim">Fim da Avaliação</label>
                                <input type="datetime-local" class="form-control" id="editFim" name="editFim">
                            </div>
                            <div class="col-2">
                                <label for="editColor">Cor do Marcador</label>
                                <input type="color" class="form-control" id="editColor" name="editColor">
                            </div>
                            <div class="col-2">
                                <label for="editValor">Valor da Avaliação</label>
                                <input type="text" class="form-control" id="editValor" name="editValor">
                            </div>
                            `;
                $("#schedule-edit-body").html(html);
                $("#editColor").val(object.borderColor);
                $("#editInicio").val(_agendamento.formatarData(object.start));
                $("#editFim").val(_agendamento.formatarData(object.end));
                $("#editTipoAvaliacao").val(object.extendedProps.tipoAvaliacao);
                $("#editValor").val(parseFloat(object.extendedProps.valor).toFixed(2));
                $("#editValor").mask("#.##0,00", {reverse: true});
                _agendamento.obterAlunos("#editAluno",object.extendedProps.idAluno)
                _agendamento.obterAvaliadores("#editAvaliador",object.extendedProps.idAvaliador)
                var modal = $("#schedule-edit");
                modal.modal('show');
            },
            customButtons: {
                agendar: {
                    text: 'Agendar Avaliação Física',
                    click: () => {
                        this.agendarAvaliacaoFisica();
                    }
                },
                filtrar: {
                    text: 'Filtrar Avaliação Física',
                    click: () => {
                        this.filtrar();
                    }
                }
            },
            headerToolbar: {
                left: 'prev,next today agendar filtrar',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            }
        });
        _calendario.render();
    }

    deletar()
    {
        Swal.fire({
            icon: "info",
            title: "Deseja confirmar exclusão?",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
        }).then((res) => {
            if(res.isConfirmed)
            {
                $.ajax({
                    url: "/AgendamentoAvaliacao/Deletar",
                    type: 'POST',
                    data: {idAgendamentoAvaliacaoFisica : document.getElementById('idAgendamentoAvaliacaoFisica').value},
                    success: (res) =>{
                        if(res)
                        {
                            Swal.fire({
                                title: res.message,
                                icon: res.icon
                            })
                            if(res.status)
                            {
                                $("#schedule-edit").modal("hide");
                                this.calendario();
                            }
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
        var dados = transForm.serialize(document.getElementById("formEdit"));
        if(this.validarAtualizarAgendamento(dados))
        {
            $.ajax({
                url: "/AgendamentoAvaliacao/Atualizar",
                type: "POST",
                data: dados,
                success: (res) =>{
                    if(res)
                    {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){
                            $("#schedule-edit").modal("hide");
                            this.calendario();
                        }
                    }
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }
    }

    formatarData(data)
    {
        var dateBR = data.toLocaleDateString();
        var datebrsplit = dateBR.split("/");
        var hora = data.toLocaleTimeString();
        return datebrsplit[2]+"-"+datebrsplit[1]+"-"+datebrsplit[0]+"T"+hora;
    }

    agendar()
    {
        var object = transForm.serialize(document.getElementById("formAgendar"));
        if(this.validarAgendar(object)){
            $.ajax({
                url: "/AgendamentoAvaliacao/Agendar",
                type: "POST",
                data: object,
                success: (res) => {
                    if(res)
                    {
                        Swal.fire({
                            title: res.message,
                            icon: res.icon
                        })
                        if(res.status){
                            $("#modalAgendar").modal("hide");
                            this.calendario();
                        }
                    }
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }
    }

    validarAtualizarAgendamento(object){
        if(object.editAluno == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um aluno'
            })
            return false;
        }

        if(object.editValor.replaceAll(',','').replaceAll('.','') < 0)
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
                icon: 'error',
                title: 'Valor da avaliação não pode ser menor que zero (0)'
            })
            return false;
        }

        if(object.editAvaliador == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um avaliador'
            })
            return false;
        }

        if(object.editColor == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar uma cor'
            })
            return false;
        }

        if(object.editFim == "")
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
                icon: 'error',
                title: 'É obrigatório colocar a data final'
            })
            return false;
        }

        if(object.editInicio < _agendamento.formatarData(new Date()) || object.editFim < _agendamento.formatarData(new Date()))
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
                icon: 'error',
                title: 'Data/hora inicio e fim deve ser superior a data/hora atual.'
            })
            return false;
        }

        if(object.editInicio >= object.editFim)
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
                icon: 'error',
                title: 'Data de inicio não pode ser maior ou igual a data Fim'
            })
            return false;
        }

        if(object.editInicio == "")
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
                icon: 'error',
                title: 'É obrigatório colocar a data inicial'
            })
            return false;
        }
        if(object.editTipoAvaliacao == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um tipo de avaliação'
            })
            return false;
        }
        return true;
    }

    validarAgendar(object){
        if(object.aluno == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um aluno'
            })
            return false;
        }

        if(object.valor.replaceAll(',','').replaceAll('.','') < 0)
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
                icon: 'error',
                title: 'Valor da avaliação não pode ser menor que zero (0)'
            })
            return false;
        }

        if(object.avaliador == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um avaliador'
            })
            return false;
        }

        if(object.color == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar uma cor'
            })
            return false;
        }

        if(object.inicio < _agendamento.formatarData(new Date()) || object.fim < _agendamento.formatarData(new Date()))
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
                icon: 'error',
                title: 'Data/hora inicio e fim deve ser superior a data/hora atual.'
            })
            return false;
        }

        if(object.fim == "")
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
                icon: 'error',
                title: 'É obrigatório colocar a data final'
            })
            return false;
        }

        if(object.inicio >= object.fim)
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
                icon: 'error',
                title: 'Data de inicio não pode ser maior ou igual a data Fim'
            })
            return false;
        }

        if(object.inicio == "")
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
                icon: 'error',
                title: 'É obrigatório colocar a data inicial'
            })
            return false;
        }
        if(object.tipoAvaliacao == "")
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
                icon: 'error',
                title: 'É obrigatório selecionar um tipo de avaliação'
            })
            return false;
        }
        return true;
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
                    var options = '<option value="">Nenhum</option>';
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

    obterAvaliadores(selector = '#avaliador',selected = false)
    {
        $.ajax({
            url: " /Usuario/ObterAvaliadores",
            type: "GET",
            success: (res) => {
                if(res)
                {
                    var options = '<option value="">Nenhum</option>';
                    res.forEach((item) => {
                        if(item.idUsuario == selected)
                        {
                            options += `<option value="${item.idUsuario}" selected>${item.nome}</option>`;
                        }
                        else{
                            options += `<option value="${item.idUsuario}">${item.nome}</option>`;
                        }
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

    agendarAvaliacaoFisica()
    {
        this.obterAlunos();
        this.obterAvaliadores();
        $('#valor').mask("#.##0,00", {reverse: true});
        var ini = moment().add(30,'minutes').format("YYYY-MM-DDTHH:mm");
        var fim = moment().add(90,'minutes').format("YYYY-MM-DDTHH:mm");
        $("#inicio").val(ini);
        $("#fim").val(fim);
        $("#modalAgendar").modal("show");
    }
}

var _agendamento;
var _calendario;

$(document).ready(() => {
    _agendamento = new Agendamento();
})