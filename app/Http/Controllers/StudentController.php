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
        // $data = $req->file("pro_pic")->store("own_files");
        $data = base64_encode($req->file("pro_pic")->getPathName());
        $student->profile_pic = $data;
        $student->profile_pic_type = Storage::mimeType($data);;

        if ($student->save()) {
            return view('add-student', ["data" => "Successfully saved"]);
        } else {
            return view('add-student', ["data" => $req->input()]);
        }
    }

    public function viewStudents()
    {
        $student = DB::table("students")->get();
        return view("view-student", ["studentData" => $student]);
    }
}
