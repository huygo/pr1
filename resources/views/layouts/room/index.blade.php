@extends('layouts.master')
@section('content')
@section('title', 'Danh sách phòng')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {!! csrf_field() !!}
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách phòng</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Danh sách phòng</li>
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

        </div>


    </section>
    <!-- /.content -->
  </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-store"></i> Name</label>
                            <input type="text" name="name" id="name" class="form-control is-valid" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-user-tie"></i> Number of students</label>
                            <input type="number" name="number" id="number" class="form-control is-valid" placeholder="Number of students" required>
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
    </div>
</div>





  <script type="text/javascript">
      search();
      // search
      function search(){
          var csrfToken = $('input[name="_token"]').val();
          var url = "{{ route('list-room') }}";
          var getData = {
              page: 1,
          }
          callAjax(url, getData, 'text', 'get', csrfToken, true).then(response=>{
              $('#content').html(response);
          })
      }

      $(document).ready(function() {
          $('.btnSave').click(function(event) {
              event.preventDefault();
              var name = ($('#name').val() != '') ? $('#name').val() : null;
              var number = ($('#number').val() != '') ? $('#number').val() : null;
              var csrfToken = $('input[name="_token"]').val();

              var url = '/room/add';
              var dataPost = {
                  name : name,
                  number : number,
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

  </script>
  <!-- /.content-wrapper -->
  @endsection
