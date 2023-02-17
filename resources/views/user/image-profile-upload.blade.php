<div class="d-none">
    <form method="POST" name="send-photo" action="{{ $route }}" enctype="multipart/form-data">
        @csrf
        <x-form-input type="file" name="profile_image" />
    </form>
</div>

@section('scripts')
    @parent
    <script>
        $(".datatables").dataTable({...config});

        $('[name="profile_image"]').change(function (e) { 
            e.preventDefault();
            $('[name="send-photo"]').submit();
        });

        $('#change-photo').click(function (e) { 
            e.preventDefault();
            $('[name="profile_image"]').click();
        });
    </script>
@endsection