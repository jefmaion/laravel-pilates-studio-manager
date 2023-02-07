@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="{{ Config::get('icons.student.index') }}" aria-hidden="true"></i>
                        Agenda
                    </h4>
                </div>

                <div class="card-body">
                    @include('classes.calendar')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('outbody')
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                
            </div>
        </div>
    </div>
@endsection


