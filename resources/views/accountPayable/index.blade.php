@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-xl-3 col-lg-6">
      <div class="card card-primary">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Em Aberto</h6>
              <span class="font-weight-bold t mb-0">R$ {{ $boxes['toPay'] }}</span>
            </div>
            <div class="col-auto">
              <div class="card-circle bg-primary text-white">
                <i class="fas fa-calendar    "></i>
              </div>
            </div>
          </div>
          {{-- <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 10%</span>
            <span class="text-nowrap"></span>
          </p> --}}
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-warning">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Receber Hoje</h6>
              <span class="font-weight-bold text-warning mb-0">R$ {{ $boxes['today'] }}</span>
            </div>
            <div class="col-auto">
              <div class="card-circle bg-orange text-white">
                <i class="fas fa-exclamation    "></i>
              </div>
            </div>
          </div>
          {{-- <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 7.8%</span>
            <span class="text-nowrap">Since last month</span>
          </p> --}}
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-success">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Pagos</h6>
              <span class="font-weight-bold text-success mb-0">R$ {{ $boxes['payed'] }}</span>
            </div>
            <div class="col-auto">
              <div class="card-circle bg-green text-white">
                <i class="fas fa-check    "></i>
              </div>
            </div>
          </div>
          {{-- <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 15%</span>
            <span class="text-nowrap">Since last month</span>
          </p> --}}
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-danger">
        <div class="card-body card-type-3">
          <div class="row">
            <div class="col">
              <h6 class="text-muted mb-0">Atrasados</h6>
              <span class="font-weight-bold text-danger mb-0">R$ {{ $boxes['late'] }}</span>
            </div>
            <div class="col-auto">
              <div class="card-circle bg-red text-white">
                <i class="fas fa-exclamation-triangle    "></i>
              </div>
            </div>
          </div>
          {{-- <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 5.4%</span>
            <span class="text-nowrap">Since last month</span>
          </p> --}}
        </div>
      </div>
    </div>
</div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                        Contas a Receber
                    </h4>

                    <div class="card-header-action">
                        <a name="" id="" class="btn btn-success btn-lg" href="{{  route('payable.create')  }}" role="button">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Adicionar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    



                  <x-data-table id="table-def">
                        <thead>
                            <tr>
                                <th>Data Cadastro</th>     
                                <th>Vencimento</th>                      
                                <th>Descrição</th>                           
                                <th>Valor</th>
                                <th>Forma de Pagamento</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                  </x-data-table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @include('layouts.plugins.datatables', ['file' => 'css'])
@endsection

@section('scripts')
    @include('layouts.plugins.datatables', ['file' => 'js'])
    <script src="{{ asset('js/datatables.config.js') }}"></script>
    <script>
        $("#table-def").dataTable({...config,
            ajax:'/account/payable',
            columns: [
                {data: 'created_at'},
                {data: 'due_date'},
                {data: 'description'},
                {data: 'value'},
                {data: 'payment_method'},
                
                {data: 'status'},
            ]
        });
    </script>
@endsection