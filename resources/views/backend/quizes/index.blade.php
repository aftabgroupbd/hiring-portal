@extends('backend.master')
@section('body')
@section('extra_css')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                User List 
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Created By</th>
                                <th>Title</th>
                                <th>Total Question</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra_js')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                order:[],
                pageLength: 10,
                ajax: "{{ route('admin.quizes.index') }}",
                columns: [
                    {data: 'created_by', name: 'created_by',orderable: false,searchable: false},
                    {data: 'title', name: 'title',orderable: false},
                    {data: 'questions', name: 'questions',orderable: false,searchable: false},
                    {data: 'status', name: 'status',orderable: false,searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
        function delete_content(id){
            var url = "{{url('admin/quizes/destroy')}}";
                swal({
                    title: "Are you sure you want to delete?",
                    text: "you will not be able to recover this request info!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: url+'/'+id,
                            data: {id:id,"_token":"{{csrf_token()}}"},
                            dataType: "json",
                            cache: false,
                            success:
                                function (data) {
                                    if (data.error == true) {
                                        swal({
                                                text: data.message,
                                                icon: "error",
                                            });
                                    }else{
                                        swal({
                                            text: data.message,
                                            icon: "success",
                                        });
                                        window.location.href = '{{route('admin.quizes.index')}}';
                                    }
                                }
                        });

                    } else {
                        swal("Not deleted!",{
                            icon: "warning",
                        });
                    }
                });
        }
    </script>
@endsection