<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 10px">#</th>
        <th>Name</th>
        <th>Email</th>
        <th style="width: 40px">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $student)
    <tr>
        <td>SV{{$student->id}}</td>
        <td>{{$student->name}}</td>
        <td>
            {{$student->email}}
        </td>
        @if(Session::get('is_student')==false)
            <td>
                <a class="btn btn-block bg-gradient-secondary" onclick="breakOut({{$student->id}})">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </td>
        @else
            <td>
                <button type="button" class="btn btn-block bg-gradient-secondary" disabled>
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </td>
        @endif
    </tr>
    @endforeach
    @if(Session::get('is_student')==false)
    <tr>
        <td></td>
        <td colspan="2">
            <select class="form-control" id="student-add">
                <option value="0" selected>Chọn sinh viên</option>
                @foreach($list_student as $student)
                <option value="{{$student->id}}">{{$student->name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <a class="btn btn-block bg-gradient-primary btnAddStudent">
                <i class="fas fa-plus-square"></i>
            </a>
        </td>
    </tr>
    @endif
    </tbody>
</table>
<input type="hidden" value="{{$id}}" id="room-id">
<script type="text/javascript">
    $(document).ready(function() {

        $('.btnAddStudent').click(function(event) {
            event.preventDefault();
            var csrfToken = $('input[name="_token"]').val();
            var url = "{{ route('addStudent') }}";
            var student_id = $('#student-add').val();
            var room_id = $('#room-id').val();
            var getData = {
                student_id: student_id,
                room_id : room_id
            }
            callAjax(url, getData, 'json', 'POST', csrfToken, true).then(response=>{
                if (response.status == true) {
                    $('#modal-info').modal('hide');
                    notifyModel();
                    $('#notify').html('Them thanh cong');
                    $("#notify").attr("style", "color:#28a745");
                }else{
                    // $('#exampleModal').modal('hide');
                    notifyModel();
                    $("#notify").attr("style", "color:red");
                    $('#notify').html(response.errors);
                }
            })

        });
    });

    function breakOut(id){
        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ route('breakOut') }}";
        var room_id = $('#room-id').val();
        var getData = {
            student_id: id,
            room_id : room_id
        }
        callAjax(url, getData, 'json', 'POST', csrfToken, true).then(response=>{
            if (response.status == true) {
                $('#modal-info').modal('hide');
                notifyModel();
                $('#notify').html('Xoa thanh cong');
                $("#notify").attr("style", "color:#28a745");
            }else{
                notifyModel();
                $("#notify").attr("style", "color:red");
                $('#notify').html(response.errors);
            }
        })
    }
</script>

