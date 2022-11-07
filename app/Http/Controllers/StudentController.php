<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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
            "pro_pic" => "required"
        ]);
        $student = new Student();
        $student->student_id = date("YmdHis");
        $student->full_name = $req->input("student_name");
        $student->dob = $req->input("student_dob");
        $data = $req->file("pro_pic")->store("own_files");
        $student->profile_pic = $data;
        $student->profile_pic_type = $data;

        if ($student->save()) {
            return view('add-student', ["data" => "Successfully saved"]);
        } else {
            return view('add-student', ["data" => $req->input()]);
        }
    }
}
