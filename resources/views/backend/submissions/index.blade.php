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
                                <th>Submitted By</th>
                                <th>Title</th>
                                <th>Total Marks</th>
                                <th>Obtain Marks</th>
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
                ajax: "{{ route('admin.submissions.index') }}",
                columns: [
                    {data: 'submitted_by', name: 'submitted_by',orderable: false,searchable: false},
                    {data: 'title', name: 'quiz.title',orderable: false},
                    {data: 'total_marks', name: 'total_marks',orderable: false,searchable: false},
                    {data: 'obtain_marks', name: 'obtain_marks',orderable: false,searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection