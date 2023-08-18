@extends('basico')

@section('conteudo')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Gastos x Receita</h1>
                    </div>
                    <hr>
                    @if(session('msg') && session('alert'))
                        <div class="alert alert-{{ session('alert') }} alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('msg') }}
                        </div>             
                    @endif
                    <div class="col-lg-12">
                        <div class="mt-5 mb-5">
                            <form class="user" action="{{ route('saida.pesquisargastosereceitas') }}" method="post">
                                @csrf
                                <div class="form-group row">

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        Data início:
                                        <input type="date" class="form-control" name="data_inicio" id="data_inicio" max="{{ date('Y-m-d') }}" required>
                                            {{ $errors->has('data_inicio') ? $errors->first('data_inicio') : '' }}
                                    </div>  
                                                                      
                                    <div class="col-sm-6">
                                        Data fim:
                                        <input type="date" class="form-control" name="data_fim" id="data_fim" max="{{ date('Y-m-d') }}" required>
                                            {{ $errors->has('data_fim') ? $errors->first('data_fim') : '' }}
                                    </div>
                                    
                                </div>
                                <button class="btn btn-primary btn-user" type="submit">
                                    Pesquisar
                                </button>
                            </form>
                        </div>
                                       

                    @if(isset($itens))
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Gastos e receita</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Mês</th>
                                                <th>Receita</th>
                                                <th>Saída</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                                <th>Mês</th>
                                                <th>Receita</th>
                                                <th>Saída</th>
                                                <th>Total</th>
                                            </tr>
                                        </tfoot>
                                        
                                        <tbody>
                                            @foreach($itens as $item)
                                            
                                            <tr>
                                                <td>{{ $item->mes }}</td>
                                                <td>R$ {{ number_format($item->receita, 2, ",", ".") }}</td>
                                                <td>R$ {{ number_format($item->saida, 2, ",", ".") }}</td>      
                                                <td>R$ {{ number_format($item->total, 2, ",", ".") }}</td>                                                
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
                <!-- /.container-fluid -->

            

@endsection