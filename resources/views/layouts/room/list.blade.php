<!-- Small Box (Stat card) -->
{{--<h5 class="mb-2 mt-4">Small Box</h5>--}}
<div class="row">
    @foreach($rooms as $room)

        @if($room->check == false)
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>000{{$room->id}}</h3>

                        <p>{{$room->name}}</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-intercom"></i>
                    </div>
                    @if(Session::get('is_student')==false)
                    <a href="#" class="small-box-footer btnInfo" onclick="openInfo({{$room->id}})">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @else
                        <a  class="small-box-footer btnInfo">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        @else
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>000{{$room->id}}</h3>

                        <p>{{$room->name}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-person-booth"></i>
                    </div>

                    <a href="#" class="small-box-footer" onclick="openInfo({{$room->id}})">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endif
    @endforeach
</div>

<div class="modal fade bd-example-modal-lg" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lableInfo">Thông tin phòng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="info-room">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{--                <button type="button" class="btn btn-primary">Send message</button>--}}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function openInfo(id){
        let csrfToken = $('input[name="_token"]').val();
        let url = "{{ route('info-room') }}";
        let getData = {
            page: 1,
            id : id,
        }
        callAjax(url, getData, 'html', 'get', csrfToken, true).then(response=>{
            $('#modal-info').modal('show');
            $('#info-room').html(response);
        })
    }
</script>
<!-- /.row -->
