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

                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('paciente.index') }}">Pacientes</a></li>
                            @if(isset($paciente))
                                <li class="breadcrumb-item active" aria-current="page">{{ $paciente->nome." ".$paciente->sobrenome }}</li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
                          @endif
                        </ol>
                    </nav>

                    <div class="col-lg-12">
                        <div class="p-3">
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
                                        Nome:
                                        <input type="text" class="form-control" name="nome" id="nome"
                                            placeholder="Nome" value="{{ $paciente->nome ?? old('nome') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-6">
                                        Sobrenome:
                                        <input type="text" class="form-control" name="sobrenome" id="sobrenome"
                                            placeholder="Sobrenome" value="{{ $paciente->sobrenome ?? old('sobrenome') }}" required>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">                                                                    
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        Data de nascimento:
                                        <input type="date" class="form-control" name="dt_nascimento" id="dt_nascimento"
                                        value="{{ $paciente->dt_nascimento ?? old('dt_nascimento') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-3">
                                        Telefone:
                                        <input type="text" class="form-control" name="telefone" id="telefone"
                                            placeholder="Telefone com DDD" value="{{ $paciente->telefone ?? old('telefone') }}" required>
                                    </div>

                                    <div class="col-sm-4">
                                        E-mail:
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="E-mail" value="{{ $paciente->email ?? old('email') }}" required>
                                            {{ $errors->first('email') ?? '' }}
                                    </div>                                    
                                    
                                    <div class="col-sm-2">
                                        CEP:
                                        <input type="number" class="form-control" name="cep" id="cep"
                                            placeholder="CEP" value="{{ $paciente->cep ?? old('cep') }}" onblur="pesquisacep(this.value);" required>
                                    </div>                                   

                                </div>

                                <div class="form-group row">                                                                    
                                <div class="col-sm-4">
                                    Cidade:
                                        <input type="text" class="form-control" name="cidade" id="cidade"
                                            placeholder="Cidade" value="{{ $paciente->cidade ?? old('cidade') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-8">
                                        Endereço:
                                        <input type="text" class="form-control" name="endereco" id="endereco"
                                            placeholder="Endereço" value="{{ $paciente->endereco ?? old('endereco') }}" required>
                                    </div>                                    
                                </div>     
                                
                                <div class="form-group row">                                                                    
                                <div class="col-sm-4">
                                        Bairro:
                                        <input type="text" class="form-control" name="bairro" id="bairro"
                                            placeholder="Bairro" value="{{ $paciente->bairro ?? old('bairro') }}" required>
                                    </div>  
                                                                      
                                    <div class="col-sm-4">
                                        Complemento:
                                        <input type="text" class="form-control" name="complemento" id="complemento"
                                            placeholder="Complemento" value="{{ $paciente->complemento ?? old('complemento') }}">
                                    </div>      
                                    
                                    <div class="col-sm-4">                                                
                                        Canal origem
                                        <select class="custom-select" name="canal_origem_id">
                                            @if(isset($canais))
                                                @foreach ( $canais as $canal )
                                                    <option value="{{ $canal->id }}" {{ (isset($paciente->canalOrigem->id) and $paciente->canalOrigem->id == $canal->id) ? 'selected' : '' }}>{{ $canal->canal }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div> 

                                </div>                                  

                                <button class="btn btn-primary mb-4" type="submit">
                                    Salvar
                                </button>
                                
                                @if(isset($paciente))
                                <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#novaConsulta">
                                    Nova consulta
                                </button>
                                @endif
                            </form>
                            
                            @if(isset($paciente))
                                <form action="{{ route('primeirasessao.store') }}" method="post">
                                    @csrf
                                    <div class="mb-4 accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Primeira sessão
                                                </button>
                                            </h2>
                                            </div>

                                            <div id="collapseOne" class="collapsing" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <input type="hidden" value="{{ $paciente->id }}" name="paciente_id">
                                                <div class="card-body">
                                                    <div class="form-group col-sm-12 row">     
                                                        
                                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                                            Data da sessão:
                                                            <input type="date" class="form-control" name="data_sessao" id="data_sessao"
                                                                value="{{ $paciente->primeiraSessao->data_sessao ?? old('data_sessao') }}" required>
                                                        </div>   

                                                        <div class="col-sm-6">
                                                            Plano de saúde:
                                                            <input type="text" class="form-control" name="plano_de_saude" id="plano_de_saude"
                                                                placeholder="Plano de saúde" value="{{ $paciente->primeiraSessao->plano_de_saude ?? old('plano_de_saude') }}" required>
                                                        </div>                                                       
                                                        
                                                    </div>         
                                                    
                                                    <h4 class="m-0 text-primary mb-3">Questionário</h4>
                                                    @if(isset($perguntas))                                                                           
                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['0']->pergunta }}                                              
                                                                <textarea class="form-control" name="p1">{{ ($paciente->primeiraSessao->p1 ?? "") ?? old('p1') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['1']->pergunta }}                                              
                                                                <textarea class="form-control" name="p2">{{ ($paciente->primeiraSessao->p2 ?? "") ?? old('p2') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['2']->pergunta }}                                              
                                                                <textarea class="form-control" name="p3">{{ ($paciente->primeiraSessao->p3 ?? "") ?? old('p3') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['3']->pergunta }}                                              
                                                                <textarea class="form-control" name="p4">{{ ($paciente->primeiraSessao->p4 ?? "") ?? old('p4') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['4']->pergunta }}                                              
                                                                <textarea class="form-control" name="p5">{{ ($paciente->primeiraSessao->p5 ?? "") ?? old('p5') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['5']->pergunta }}                                              
                                                                <textarea class="form-control" name="p6">{{ ($paciente->primeiraSessao->p6 ?? "") ?? old('p6') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['6']->pergunta }}                                              
                                                                <textarea class="form-control" name="p7">{{ ($paciente->primeiraSessao->p7 ?? "") ?? old('p7') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['7']->pergunta }}                                              
                                                                <textarea class="form-control" name="p8">{{ ($paciente->primeiraSessao->p8 ?? "") ?? old('p8') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['8']->pergunta }}                                              
                                                                <textarea class="form-control" name="p9">{{ ($paciente->primeiraSessao->p9 ?? "") ?? old('p9') }}</textarea>
                                                            </div>

                                                            <div class="form-group mb-3 col-sm-12">
                                                                {{ $perguntas['9']->pergunta }}                                              
                                                                <textarea class="form-control" name="p10">{{ ($paciente->primeiraSessao->p10 ?? "") ?? old('p10') }}</textarea>
                                                            </div>
                                                    @endif

                                                    <div class="form-group mb-3 col-sm-6">                                                
                                                            Anamnese
                                                            <select class="custom-select" name="anamnese">
                                                                <option value="sim" {{ ((isset($paciente->primeiraSessao->anamnese) and $paciente->primeiraSessao->anamnese == 'sim') ? 'selected' : '') ?? old('anamnese') }}>Sim</option>
                                                                <option value="não" {{ ((isset($paciente->primeiraSessao->anamnese) and $paciente->primeiraSessao->anamnese == 'não') ? 'selected' : '') ?? old('anamnese') }}>Não</option>
                                                            </select>
                                                        
                                                    </div>
                                                    
                                                    <div class="form-group mb-3 col-sm-12">
                                                        Hipóteses Diagnóstica
                                                        <textarea class="form-control" name="hipoteses_diagnostica">{{ $paciente->primeiraSessao->hipoteses_diagnostica ?? old('hipoteses_diagnostica') }}</textarea>
                                                    </div>
                                                    
                                                    <div class="form-group mb-3 col-sm-12">
                                                        Metas terapêuticas da sessão:                                             
                                                        <textarea class="form-control" name="metas_terapeuticas" rows="4">{{ $paciente->primeiraSessao->metas_terapeuticas ?? old('metas_terapeuticas') }}</textarea>
                                                    </div>

                                                    <div class="form-group mb-3 col-sm-12">
                                                        Anotações relevantes:                  
                                                        <textarea class="form-control" name="anotacoes_relevantes" rows="4">{{ $paciente->primeiraSessao->anotacoes_relevantes ?? old('anotacoes_relevantes') }}</textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-info mb-4">
                                                        Salvar
                                                    </button>

                                                </div>                                    
                                            </div>
                                        </div>                            
                                    </div>          
                                </form>
                                
                                
                                <form action="{{ route('avaliacao.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                                    <div class="mb-4 accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#avaliacao" aria-expanded="true" aria-controls="collapseOne">
                                                    Avaliação
                                                </button>
                                            </h2>
                                            </div>

                                            <div id="avaliacao" class="collapsing" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <input type="hidden" value="{{ $paciente->id }}" name="paciente_id">
                                                <div class="card-body">
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#familia" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Família</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="familia">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="familia_avalicao_1_a_5" rows="3">{{ isset($avaliacao->familia_avalicao_1_a_5) ? $avaliacao->familia_avalicao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="familia_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->familia_gostaria_de_alcancar) ? $avaliacao->familia_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="familia_dificuldades" rows="3">{{ isset($avaliacao->familia_dificuldades) ? $avaliacao->familia_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="familia_diferente" rows="3">{{ isset($avaliacao->familia_diferente) ? $avaliacao->familia_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#saude" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Saúde</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="saude">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="saude_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->saude_avaliacao_1_a_5) ? $avaliacao->saude_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="saude_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->saude_gostaria_de_alcancar) ? $avaliacao->saude_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="saude_dificuldades" rows="3">{{ isset($avaliacao->saude_dificuldades) ? $avaliacao->saude_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="saude_diferente" rows="3">{{ isset($avaliacao->saude_diferente) ? $avaliacao->saude_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#profissional" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Profissional</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="profissional">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="profissional_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->profissional_avaliacao_1_a_5) ? $avaliacao->profissional_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="profissional_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->profissional_gostaria_de_alcancar) ? $avaliacao->profissional_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="profissional_dificuldades" rows="3">{{ isset($avaliacao->profissional_dificuldades) ? $avaliacao->profissional_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="profissional_diferente" rows="3">{{ isset($avaliacao->profissional_diferente) ? $avaliacao->profissional_diferente : '' }}</textarea>
                                                        </div>

                                                    </div> 
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#lazer" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Lazer</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="lazer">

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="lazer_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->lazer_avaliacao_1_a_5) ? $avaliacao->lazer_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="lazer_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->lazer_gostaria_de_alcancar) ? $avaliacao->lazer_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="lazer_dificuldades" rows="3">{{ isset($avaliacao->lazer_dificuldades) ? $avaliacao->lazer_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="lazer_diferente" rows="3">{{ isset($avaliacao->lazer_diferente) ? $avaliacao->lazer_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>   
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#financeiro" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Financeiro</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="financeiro">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="financeiro_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->financeiro_avaliacao_1_a_5) ? $avaliacao->financeiro_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="financeiro_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->financeiro_gostaria_de_alcancar) ? $avaliacao->financeiro_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="financeiro_dificuldades" rows="3">{{ isset($avaliacao->financeiro_dificuldades) ? $avaliacao->financeiro_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="financeiro_diferente" rows="3">{{ isset($avaliacao->financeiro_diferente) ? $avaliacao->financeiro_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>  
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#afetiva" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Afetiva</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="afetiva">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="afetiva_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->afetiva_avaliacao_1_a_5) ? $avaliacao->afetiva_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="afetiva_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->afetiva_gostaria_de_alcancar) ? $avaliacao->afetiva_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="afetiva_dificuldades" rows="3">{{ isset($avaliacao->afetiva_dificuldades) ? $avaliacao->afetiva_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="afetiva_diferente" rows="3">{{ isset($avaliacao->afetiva_diferente) ? $avaliacao->afetiva_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>   
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#academia" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Academia</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="academia">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="academia_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->academia_avaliacao_1_a_5) ? $avaliacao->academia_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="academia_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->academia_gostaria_de_alcancar) ? $avaliacao->academia_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="academia_dificuldades" rows="3">{{ isset($avaliacao->academia_dificuldades) ? $avaliacao->academia_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="academia_diferente" rows="3">{{ isset($avaliacao->academia_diferente) ? $avaliacao->academia_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>

                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#espiritualidade" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Espiritualidade</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="espiritualidade">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="espiritualidade_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->espiritualidade_avaliacao_1_a_5) ? $avaliacao->espiritualidade_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="espiritualidade_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->espiritualidade_gostaria_de_alcancar) ? $avaliacao->espiritualidade_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="espiritualidade_dificuldades" rows="3">{{ isset($avaliacao->espiritualidade_dificuldades) ? $avaliacao->espiritualidade_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="espiritualidade_diferente" rows="3">{{ isset($avaliacao->espiritualidade_diferente) ? $avaliacao->espiritualidade_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>                                                    

                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#social" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Social</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="social">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="social_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->social_avaliacao_1_a_5) ? $avaliacao->social_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="social_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->social_gostaria_de_alcancar) ? $avaliacao->social_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="social_dificuldades" rows="3">{{ isset($avaliacao->social_dificuldades) ? $avaliacao->social_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="social_diferente" rows="3">{{ isset($avaliacao->social_diferente) ? $avaliacao->social_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>      
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#justica_social" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Justiça Social</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="justica_social">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="justica_social_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->justica_social_avaliacao_1_a_5) ? $avaliacao->justica_social_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="justica_social_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->justica_social_gostaria_de_alcancar) ? $avaliacao->justica_social_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="justica_social_dificuldades" rows="3">{{ isset($avaliacao->justica_social_dificuldades) ? $avaliacao->justica_social_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="justica_social_diferente" rows="3">{{ isset($avaliacao->justica_social_diferente) ? $avaliacao->justica_social_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>      
                                                    
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#autoconceito" aria-expanded="true" aria-controls="collapseOne">
                                                        <h5 class="m-0 text-primary mb-3">Autoconceito</h5>
                                                    </button>
                                                    <hr>
                                                    <div class="form-group col-sm-12 row collapsing" id="autoconceito">     
                                                        
                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Avaliação 1 a 5:
                                                            <textarea class="form-control" name="autoconceito_avaliacao_1_a_5" rows="3">{{ isset($avaliacao->autoconceito_avaliacao_1_a_5) ? $avaliacao->autoconceito_avaliacao_1_a_5 : '' }}</textarea>
                                                        </div> 

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria de alcançar?
                                                            <textarea class="form-control" name="autoconceito_gostaria_de_alcancar" rows="3">{{ isset($avaliacao->autoconceito_gostaria_de_alcancar) ? $avaliacao->autoconceito_gostaria_de_alcancar : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            Quais são as sua dificuldades?
                                                            <textarea class="form-control" name="autoconceito_dificuldades" rows="3">{{ isset($avaliacao->autoconceito_dificuldades) ? $avaliacao->autoconceito_dificuldades : '' }}</textarea>
                                                        </div>

                                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                                            O que gostaria que fosse diferente?
                                                            <textarea class="form-control" name="autoconceito_diferente" rows="3">{{ isset($avaliacao->autoconceito_diferente) ? $avaliacao->autoconceito_diferente : '' }}</textarea>
                                                        </div>

                                                    </div>    
                                                    
                                                    <button type="submit" class="btn btn-info mb-4">
                                                        Salvar
                                                    </button>
                                                </div>
                                            </div>                            
                                        </div>
                                    </div>          
                                </form>

                            @endif

                            @if(isset($consultas))
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 text-primary">Consultas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Data consulta</th>
                                                        <th>Tratamento</th>
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th colspan="3" class="text-center">Opções</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Data consulta</th>
                                                        <th>Tratamento</th>
                                                        <th>Inicio</th>
                                                        <th>Fim</th>
                                                        <th colspan="3" class="text-center">Opções</th>
                                                    </tr>
                                                </tfoot>
                                                
                                                <tbody>
                                                    @foreach($consultas as $consulta)
                                                    
                                                    <tr>                                            
                                                        <td>{{ date("d/m/Y", strtotime($consulta->inicio_consulta)) }}</td>
                                                        <td>{{ $consulta->tratamento->tratamento }}</td>
                                                        <td>{{ date("H:i", strtotime($consulta->inicio_consulta)) }}</td>
                                                        <td>{{ date("H:i", strtotime($consulta->fim_consulta)) }}</td>
                                                        <td><button class="btn btn-info" data-toggle="modal" data-target="#atualizaConsulta" onclick="pegaConsulta({{ $consulta }})" {{ $consulta->pagamento == 'realizado' ? 'disabled' : '' }}>Editar</button></td>
                                                        <td><a href="{{ route('registrosessao', [ 'id_consulta' => $consulta->id, 'id_paciente' => $paciente->id ]) }}" class="btn btn-primary">Visualizar</a></td>
                                                        <td>
                                                            <form id="form_{{ $consulta->id }}" method="post" action="/consulta/{{ $consulta->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="paciente_id" value="{{ $consulta->paciente_id }}">
                                                                <button class="btn btn-danger" onclick="document.getElementById('form_{{ $consulta->id }}').submit()" {{ $consulta->pagamento == 'realizado' ? 'disabled' : '' }}>Cancelar</button>
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

<!--                 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <form id="form_atualiza" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <input type="hidden" name="paciente_id" id="paciente_id" value="" />
                                <input type="hidden" name="id" id="id" value="" />  
                                <input type="hidden" name="consulta_id" id="consulta_id" value="" />                            
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
                </div> -->

                @include('componentes.modal_editar_criar')                 
                
<script src="{{ asset('js/cep.js') }}"></script>
<script>

    function pegaConsulta(consulta){
        console.log(consulta);
        document.getElementById('a_inicio_consulta').value = consulta.inicio_consulta;
        document.getElementById('a_fim_consulta').value = consulta.fim_consulta;
        document.getElementById('a_id').value = consulta.id;
        document.getElementById('a_paciente_id').value = consulta.paciente_id;
        document.getElementById('a_tratamento_id').value = consulta.tratamento_id;
        document.getElementById('a_pagamento_id').value = consulta.pagamento_id;
        document.getElementById('a_pagamento').value = consulta.pagamento;
        consulta.pagamento == "realizado" ? document.getElementById('a_pagamento').setAttribute("disabled", true) : document.getElementById('a_pagamento').removeAttribute("disabled");
        document.getElementById('form_atualiza').setAttribute("action", "/consulta/"+consulta.id);
    }

</script>
@endsection