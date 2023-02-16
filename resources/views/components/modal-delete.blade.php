{{ $slot }}
@section('outbody')
@parent
<!-- Modal -->
<div class="modal fade show" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ $route }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"> <i class="fas fa-trash    "></i>
                        Excluir</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                            class="fas fa-times    "></i> Fechar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection