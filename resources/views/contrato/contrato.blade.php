@extends('base')

@section('main')

@include('layouts.navbars.navbar')
<div id="msgVazio" style="position:absolute;z-index:9999">

</div>

<div class="container mt--8 pb-5">
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div>
                    <div id="modalPesquisa">
                    </div>
                    <div id="modalEdit">
                        
                    </div>
                    <x-header />
                    <div class="container">
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert">

                            <ul style="list-style: none;">
                                <li style="color:red">{{ $error }}</li>
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class='card-body px-lg-3 py-lg-1'>

                        <form method="post" action="{{ route('contratoTela.store') }}">
                            @csrf

                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control dados" placeholder="CNPJ" type="text" name="cnpj" >

                                    <button type="search" value="cnpj" class="btn btn-primary btn-fab btn-icon btn-round btn-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div style="display:none" id="cnpj" class="alert alert-danger" role="alert">
                                    Busca não encontrada : CNPJ vazio,tente digitar um valor.
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control dados" placeholder="RAZAOSOCIAL" type="text" name="razaosocial" >
                                    <span class="emptyField"></span>
                                    <button type="search" class="btn btn-primary btn-fab btn-icon btn-round btn-search" value="razaosocial">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div style="display:none" id="razaosocial" class="alert alert-danger" role="alert">
                                    Busca não encontrada : Razao social vazio,tente digitar um valor.
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <input class="form-control dados" placeholder="NOMEFANTASIA" type="text" name="nomefantasia" >
                                    <button type="search" value="nomefantasia" class="btn btn-primary btn-fab btn-icon btn-round btn-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div style="display:none" id="nomefantasia" class="alert alert-danger" role="alert">
                                    Busca não encontrada : Nome fantasia vazio,tente digitar um valor.
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="EMAIL" type="text" name="email" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="in_User" type="text" name="in_User" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-cloud-upload-96"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file" name="logomarca" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="custom-select" name="status" id="status">
                                    <option value="0">0 - Ativado</option>
                                    <option value="1">1 - Desativado</option>
                                </select>
                            </div>
                            <x-panel />
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footers.guest')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $('.btn-search').click(function(e) {
        e.preventDefault();

        let cnpj = $("input[placeholder=CNPJ]").val() == '' ? '' : $("input[placeholder=CNPJ]").val()
        let razaosocial = $("input[placeholder=RAZAOSOCIAL]").val() == '' ? '' : $("input[placeholder=RAZAOSOCIAL]").val()
        let nomefantasia = $("input[placeholder=NOMEFANTASIA]").val() == '' ? '' : $("input[placeholder=NOMEFANTASIA]").val()



        cnpj = cnpj.replace(/[^a-zA-Z0-9 ]/g, "")

        let url = '{{ route("contratoTela/search", ":id") }}';
        url = url.replace(':id', cnpj);

        // if (cnpj != '' || razaosocial != '' || nomefantasia != '') {

        $.ajax({
            type: 'POST',
            url: "{{ route('contratoTela/search')}}",
            data: {
                cnpj: cnpj,
                razaosocial: razaosocial,
                nomefantasia: nomefantasia,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#modalPesquisa').html(data);

                $('#modalContrato').click();
            },

        });

    });



    $("button[value]").click(function() {
        let dados = {
            'cnpj': 'cnpj',
            'razaosocial': 'razaosocial',
            'nomefantasia': 'nomefantasia'
        }
        let registroNome = $(this).val()

        let registroValor = $('input[name=' + registroNome + ']').val()

        for (i in dados) {
            if (registroNome == dados[i] && registroValor == '') {
                $('#' + dados[i]).show()
            }
        }
    })

    $('input[name]').keypress(function() {
        let dados = {
            'cnpj': 'cnpj',
            'razaosocial': 'razaosocial',
            'nomefantasia': 'nomefantasia'
        }
        let registro = $(this).attr('name')
        let valorRegistro = $(this).val()

        for (i in dados) {
            if (registro == dados[i]) {
                if (valorRegistro == '') {
                    $('#' + dados[i]).hide()
                }
            }
        }
    })

    $('button[type=button]').click(function() {
        let btnValue = $(this).val()
        if (btnValue == "Alterar") {
            $.ajax({
                type: 'POST',
                url: "{{ route('contratoTela/exibir')}}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#modalEdit').html(data);

                    $('#editModal').click();
                },

            });


        }
    })
</script>

@endsection