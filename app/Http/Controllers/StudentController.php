<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function loadView()
    {
        return view("add-student", ["data" => []]);
    }

    public function add(Request $req)
    {
        $req->validate([
            "student_name" => "required",
            "student_dob" => "required|date",
            "pro_pic" => "required|mimes:jpeg,jpg,png,gif|max:1024" // Size in kb
        ]);
        $student = new Student();
        $student->student_id = date("YmdHis");
        $student->full_name = $req->input("student_name");
        $student->dob = $req->input("student_dob");
        $data = $req->file("pro_pic")->store("own_files");
        $student->profile_pic = $data;
        $student->profile_pic_type = Storage::mimeType($data);

        if ($student->save()) {
            return view('add-student', ["data" => "Successfully saved"]);
        } else {
            return view('add-student', ["data" => $req->input()]);
        }
    }

    public function update(Request $req)
    {
        $req->validate([
            "student_name" => "required",
            "student_dob" => "required|date",
            "pro_pic" => "mimes:jpeg,jpg,png,gif|max:1024" // Size in kb
        ]);
        $student = Student::find($req->input("student_id"));
        $student->student_id = $req->input("student_id");
        $student->full_name = $req->input("student_name");
        $student->dob = $req->input("student_dob");
        $data = $req->file("pro_pic");
        if ($data) {
            $data = $data->store("own_files");
            $student->profile_pic = $data;
            $student->profile_pic_type = Storage::mimeType($data);
        }

        if ($student->save()) {
            return redirect("edit-student/" . $req->input("student_id"));
        } else {
            return view('edit-student', ["data" => $req->input()]);
        }
    }
    public function viewStudents()
    {
        $student = DB::table("students")->get();
        return view("view-student", ["studentData" => $student]);
    }
    public function getStudent($studentId)
    {
        $student = Student::find($studentId);
        return view("edit-student", ["data" => $student]);
    }
    public function deleteStudent($studentId)
    {
        $data = Student::find($studentId);
        $data->delete();
        return redirect("view-student");
    }
}
