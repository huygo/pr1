@extends('layouts.master')
@section('content')
@section('title', 'Danh sách sinh vien')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {!! csrf_field() !!}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách sinh viên</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Danh sách sinh viên</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="nav-icon far fa-plus-square"></i> Thêm mới
        </button>
        <br>
        <br>
        <div id="content">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $student)
                    <tr>
                        <td>SV{{$student->id}}</td>
                        <td>{{$student->name}}
                        </td>
                        <td>{{$student->email}}</td>
                        <td> {{$student->created_at}}</td>
                        <td>{{$student->updated_at}}</td>
                        <td>
                            <button type="button" class="btn btn-block btn-danger" onclick="deleteStudent({{$student->id}})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
{{--        <form method="post" action="/student">--}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-warning">
                    <div class="card-body">
                            <!-- input states -->
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" name="name" id="name" class="form-control is-valid" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="email" id="email" class="form-control is-valid" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-phone-square"></i> Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control is-valid" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" name="password" id="password" class="form-control is-valid" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="inputSuccess"><i class="fas fa-lock"></i> Retype password</label>
                                <input type="password" name="re_password" id="re_password" class="form-control is-valid" placeholder="Retype password" required>
                            </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary btnSave">Lưu lại</button>
            </div>
        </div>
{{--        </form>--}}
    </div>
</div>
<script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('template') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('template') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function() {
        $('.btnSave').click(function(event) {
            event.preventDefault();
            var name = ($('#name').val() != '') ? $('#name').val() : null;
            var email = ($('#email').val() != '') ? $('#email').val() : null;
            var phone = ($('#phone').val() != '') ? $('#phone').val() : null;
            var password = ($('#password').val() != '') ? $('#password').val() : null;
            var re_password = ($('#re_password').val() != '') ? $('#re_password').val() : null;
            var csrfToken = $('input[name="_token"]').val();

            var url = '/student';
            var dataPost = {
                name : name,
                email : email,
                phone : phone,
                password : password,
                re_password : re_password,
            };
            var type = 'json';
            var method = 'POST';
            callAjax(url, dataPost, type, method, csrfToken, 1).then(res => {
                if (res.status == true) {
                    location.reload();
                }else{
                    // $('#exampleModal').modal('hide');
                    notifyModel();
                    $("#notify").attr("style", "color:red");
                    $('#notify').html(res.errors);
                }
            });

        });
    });
    function deleteStudent(id){
        let result = confirm("Are you sure you want to delete?");
        if (result) {
            let csrfToken = $('input[name="_token"]').val();
            let url = "{{ route('deleteStudent') }}";
            let getData = {
                id: id,
            }
            callAjax(url, getData, 'json', 'POST', csrfToken, true).then(response=>{
                if (response.status == true) {
                    location.reload();
                }else{
                    notifyModel();
                    $("#notify").attr("style", "color:red");
                    $('#notify').html(response.errors);
                }
            })
        }
    }
</script>
@endsection
