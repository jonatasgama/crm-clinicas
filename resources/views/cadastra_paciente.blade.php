@extends('basico')

@section('conteudo')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h1 class="h3 mb-0 text-gray-800">{{ $funcao }} Paciente</h1>
                    </div>
                    <hr>
                    @if(session('msg') && session('alert'))
                        <div class="alert alert-{{ session('alert') }} alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('msg') }}
                        </div>             
                    @endif
                    <div class="col-lg-12">
                        <div class="p-5">
                            @if(isset($paciente->id))
                            <form class="user" action="{{ route('paciente.update', [ 'paciente' => $paciente->id ]) }}" method="post">
                                @csrf
                                @method('PUT')
                            @else
                            <form class="user" action="{{ route('paciente.store') }}" method="post">
                                @csrf
                            @endif
                                <div class="form-group row">                                                                    
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="nome" id="nome"
                                            placeholder="Nome" value="{{ $paciente->nome ?? old('nome') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="sobrenome" id="sobrenome"
                                            placeholder="Sobrenome" value="{{ $paciente->sobrenome ?? old('sobrenome') }}" required>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">                                                                    
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <input type="date" class="form-control form-control-user" name="dt_nascimento" id="dt_nascimento"
                                        value="{{ $paciente->dt_nascimento ?? old('dt_nascimento') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-user" name="telefone" id="telefone"
                                            placeholder="Telefone com DDD" value="{{ $paciente->telefone ?? old('telefone') }}" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control form-control-user" name="email" id="email"
                                            placeholder="E-mail" value="{{ $paciente->email ?? old('email') }}" required>
                                            {{ $errors->first('email') ?? '' }}
                                    </div>                                    
                                    
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control form-control-user" name="cep" id="cep"
                                            placeholder="CEP" value="{{ $paciente->cep ?? old('cep') }}" onblur="pesquisacep(this.value);" required>
                                    </div>                                   

                                </div>

                                <div class="form-group row">                                                                    
                                <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-user" name="cidade" id="cidade"
                                            placeholder="Cidade" value="{{ $paciente->cidade ?? old('cidade') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-user" name="endereco" id="endereco"
                                            placeholder="Endereço" value="{{ $paciente->endereco ?? old('endereco') }}" required>
                                    </div>                                    
                                </div>     
                                
                                <div class="form-group row">                                                                    
                                <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-user" name="bairro" id="bairro"
                                            placeholder="Bairro" value="{{ $paciente->bairro ?? old('bairro') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-user" name="complemento" id="complemento"
                                            placeholder="Complemento" value="{{ $paciente->complemento ?? old('complemento') }}">
                                    </div>                                    
                                </div>                                  

                                <button class="btn btn-primary mb-4" type="submit">
                                    Salvar
                                </button>
                                
                                <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#novaConsulta">
                                    Nova consulta
                                </button>
                            </form>
                        
                                    

                            @if(isset($consultas))
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Consultas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Data consulta</th>
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th colspan="2">Opções</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                        <th>Data consulta</th>
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th colspan="2">Opções</th>
                                                    </tr>
                                                </tfoot>
                                                
                                                <tbody>
                                                    @foreach($consultas as $consulta)
                                                    
                                                    <tr>                                            
                                                        <td>{{ date("d/m/Y", strtotime($consulta->inicio_consulta)) }}</td>
                                                        <td>{{ date("H:i", strtotime($consulta->inicio_consulta)) }}</td>
                                                        <td>{{ date("H:i", strtotime($consulta->fim_consulta)) }}</td>
                                                        <td><button class="btn btn-info" data-toggle="modal" data-target="#editModal" onclick="pegaConsulta({{ $consulta }})">Editar</button></td>
                                                        <td>
                                                            <form id="form_{{ $consulta->id }}" method="post" action="/consulta/{{ $consulta->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="paciente_id" value="{{ $consulta->paciente_id }}">
                                                                <button class="btn btn-danger" onclick="document.getElementById('form_{{ $consulta->id }}').submit()">Cancelar</button>
                                                            </form>                                                             
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>                
                            @endif  
                            
                        </div>
                        
                    </div>    

                </div>
                <!-- /.container-fluid -->

                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form id="form_atualiza" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <input type="hidden" name="paciente_id" id="paciente_id" value="" />
                                <input type="hidden" name="id" id="id" value="" />                            
                                <div class="modal-body">
                                    <h4>Editar Consulta</h4>

                                    Início da consulta:
                                    <br />
                                    <input type="datetime-local" class="form-control" name="inicio_consulta" id="inicio_consulta">

                                    Fim da consulta:
                                    <br />
                                    <input type="datetime-local" class="form-control" name="fim_consulta" id="fim_consulta">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Atualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="novaConsulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form method="post" action="{{ route('consulta.store') }}">
                            @csrf
                            <div class="modal-content">
                                <input type="hidden" name="event_id" id="event_id" value="" />
                                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}" />                            
                                <div class="modal-body">
                                    <h4>Nova Consulta para {{ $paciente->nome }}</h4>

                                    Início da consulta:
                                    <br />
                                    <input type="datetime-local" class="form-control" name="inicio_consulta" id="inicio_consulta" required>

                                    Fim da consulta:
                                    <br />
                                    <input type="datetime-local" class="form-control" name="fim_consulta" id="fim_consulta" required>
                                
                                    Tratamento:
                                    <br />
                                    <select name="tratamento_id" class="form-control">
                                        <option>--- Selecione um tratamento ---</option>

                                        @foreach($tratamentos as $tratamento)
                                        <option value="{{ $tratamento->id }}" > {{ $tratamento->tratamento }}</option>
                                        @endforeach
                                    </select>    
                                    
                                    Forma de pagamento:
                                    <br />
                                    <select name="pagamento_id" class="form-control">
                                        <option>--- Selecione uma forma de pagamento ---</option>

                                        @foreach($pagamentos as $pagamento)
                                        <option value="{{ $pagamento->id }}" > {{ $pagamento->forma_pagamento }}</option>
                                        @endforeach
                                    </select> 
                                    
                                    Pagamento:
                                    <br />
                                    <select name="pagamento" class="form-control">
                                        <option value="pendente">Pendente</option>
                                        <option value="realizado">Realizado</option>
                                    </select>                                      
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary" >Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                 
                
<script src="{{ asset('js/cep.js') }}"></script>
<script>

    function pegaConsulta(consulta){
        console.log(consulta);
        document.getElementById('inicio_consulta').value = consulta.inicio_consulta;
        document.getElementById('fim_consulta').value = consulta.fim_consulta;
        document.getElementById('id').value = consulta.id;
        document.getElementById('paciente_id').value = consulta.paciente_id;
        document.getElementById('form_atualiza').setAttribute("action", "/consulta/"+consulta.id);
    }

</script>
@endsection