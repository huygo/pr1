<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\StudentInRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $student = User::where('status',User::STUDENT)->get();
        $student_count = $student->count();
        $rooms = Room::where('status','>',Room::STATUS_DELETE)->get();
        $rooms_count = $rooms->count();
        if ($request->session()->get('is_student') == true){
            return view('layouts.home_student',compact('student_count','rooms_count'));
        }else{
            $arrayDay = [];
            $date = date('Y-m-d');
            for ($i=6; $i>=1;$i--){
                $d = date ( 'Y-m-d' , strtotime ( '-'.$i.' day' , strtotime ($date)));
                $arrayDay[$i]['date'] = date ( 'd/m' , strtotime ( '-'.$i.' day' , strtotime ($date)));
                $arrayDay[$i]['student'] = $student->where('created_at','>=',$d.' 00:00:00')->where('created_at','<',$d.' 23:59:59')->count();
                $arrayDay[$i]['room'] = $rooms->where('created_at','>=',$d.' 00:00:00')->where('created_at','<',$d.' 23:59:59')->count();
            }
            $d =  date('Y-m-d');
            $arrayDay[0]['date'] = date('d/m');
            $arrayDay[0]['student'] = $student->where('created_at','>=',$d.' 00:00:00')->where('created_at','<',$d.' 23:59:59')->count();
            $arrayDay[0]['room'] = $rooms->where('created_at','>=',$d.' 00:00:00')->where('created_at','<',$d.' 23:59:59')->count();
            return view('layouts.home',compact('student_count','rooms_count','arrayDay'));
        }
    }

    public function room(Request $request)
    {
        return view('layouts.room.index');
    }

    public function listRoom(Request $request){
        $rooms = Room::where('status','>',Room::STATUS_DELETE)->get();
        if ($request->session()->get('is_student') == true) {
            foreach ($rooms as $room) {
                $studenInRoom = StudentInRoom::where('room_id', $room->id)->where('student_id', Auth::user()->id)->first();
                if (!empty($studenInRoom)){
                    if ($room->id == $studenInRoom->room_id) {
                        $room->check = true;
                    }
                }else {
                    $room->check = false;
                }
            }
        }else{
            foreach ($rooms as $room) {
                $studenInRoom = StudentInRoom::where('room_id', $room->id);
                if ($room->number <= $studenInRoom->count()) {
                    $room->check = true;
                } else {
                    $room->check = false;
                }
            }
        }
        return view('layouts.room.list',compact('rooms'));
    }

    public function infoRoom(Request $request){
        $data = $request->all();
        $id = $data['id'] ?? 0;
        $studenInRoom = StudentInRoom::where('room_id',$id)->get();
        $studenId = $studenInRoom->pluck('student_id')->toArray();
        $student = User::where('status',User::STUDENT)->get();
        $data = $student->whereIn('id',$studenId);
        $list_student = $student->whereNotIn('id',$studenId);

        return view('layouts.room.info',compact('data','list_student','id'));
    }

    public function addStudent(Request $request){
        $data = $request->all();
        $rooms = Room::where('status','>',Room::STATUS_DELETE)->where('id',$data['room_id'])->first();
        $studenInRoom = StudentInRoom::where('room_id',$data['room_id']);
        if ($rooms->number <= $studenInRoom->count()) {
            return response()->json(['status'=> false,'errors'=>'Số lượng sinh viên phòng này đã đủ'],200);
        }
        $student = $studenInRoom->where('student_id',$data['student_id'])->first();
        if (!empty($student)) {
            return response()->json(['status'=> false,'errors'=>'Sinh viên đã tồn tại trong phòng này'],200);
        }
        StudentInRoom::create([
            'student_id' => $data['student_id'],
            'room_id' => $data['room_id']
        ]);
        return response()->json(['status'=> true],200);
    }

    public function breakOut(Request $request){
        $data = $request->all();
        $studenInRoom = StudentInRoom::where('room_id',$data['room_id'])->where('student_id',$data['student_id'])->first();
        if (empty($studenInRoom)) {
            return response()->json(['status'=> false,'errors'=>'Khong tim thay sinh vien nay'],200);
        }
        $studenInRoom->delete();
        return response()->json(['status'=> true],200);
    }

    public function student(Request $request)
    {
        $data = User::where('status',User::STUDENT)->orderBy('id','desc')->get();
        return view('layouts.student',compact('data'));
    }

    public function saveStudent(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            're_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> false,'errors'=>$validator->errors()->first()],200);
        }
        $data = $request->all();
        if ($data['password'] != $data['re_password']){
            return response()->json(['status'=> false,'errors'=>'Re-entered password does not match'],200);
        }
        $check = $this->create($data);
        return response()->json(['status'=> true],200);
    }

    public function deleteStudent(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> false,'errors'=>$validator->errors()->first()],200);
        }
        $data = $request->all();
        $student = User::where('status',User::STUDENT)->where('id',$data['id'])->first();
        if (empty($student)){
            return response()->json(['status'=> false,'errors'=>'Không tìm thấy thông tin sinh viên'],200);
        }
        $student->delete();
        return response()->json(['status'=> true],200);
    }

    public function addRoom(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> false,'errors'=>$validator->errors()->first()],200);
        }
        $data = $request->all();
        Room::create([
            'name' => $data['name'],
            'number' => $data['number'],
            'status' => Room::STATUS_ACTIVE
        ]);
        return response()->json(['status'=> true],200);
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => User::STUDENT
        ]);
    }
}
