<?php

namespace App\Http\Controllers;

use App\Models\Employee as ModelsEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

class Employee extends Controller
{
    private $rules = [];
    private $messages = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        $this->rules = [
            "employee_name" => "required",
            "employee_email" => "required|email:filter|unique:employees,employee_email"
        ];
        $this->messages = [
            "employee_name.required" => "Name is required",
            "employee_email.required" => "Email is required",
            "employee_email.email" => "Invalid email",
            "employee_email.unique" => "Duplicate email"
        ];
    }
    public function index()
    {
        $data = ModelsEmployee::all();
        if (sizeof($data) > 0) {
            return ["statusCode" => 200, "result" => response()->json($data, 200)->original];
        } else {
            return [
                "statusCode" => 400,
                "result" => response()->json("No records found", 400)->original
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $fileErr = "";
        $filesAllowed = array("jpg", "jpeg", "png");
        $userData = json_decode($request->input_data, true);
        $validator = Validator::make($userData, $this->rules, $this->messages);
        if ($request->has("employee_pic")) {
            $picture = $request->employee_pic;
            $fileExtension = strtolower($picture->getClientOriginalExtension());
            $fileName = date("YmdHis") . "." . $fileExtension;
            $fileSize = $picture->getSize();
            if (!(in_array($fileExtension, $filesAllowed))) {
                $fileErr = "Upload JPEG,JPG,PNG files";
            } else {
                if ($fileSize > 1000000) {
                    $fileErr = "Upload less than or equal to 1 MB";
                }
            }
        } else {
            $fileErr = "";
        }
        if (!$validator->fails() && $fileErr == "") {
            $path = public_path("own_files");
            $picture->move($path, $fileName);
            $emp = new ModelsEmployee();
            $emp->employee_id = date("YmdHis");
            $emp->employee_name = $userData['employee_name'];
            $emp->employee_email = $userData['employee_email'];
            // $emp->employee_pic = $fileName;
            $emp->employee_pic = url("/own_files/$fileName");
            $emp->employee_pic_type = $picture->getClientMimeType();
            $result = $emp->save();
            if ($result) {
                return ["statusCode" => 201, "result" => response()->json("Successfully inserted", 201)->original];
            } else {
                return ["statusCode" => 500, "result" => response()->json("Internal server error", 500)->original];
            }
        } else {
            return response()->json([
                "statusCode" => 400,
                "error" => ["employee_pic" => $fileErr, "data" => $validator->errors()]
            ], 400)->original;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ModelsEmployee::find($id);
        if (!empty($data)) {
            return ["statusCode" => 200, "result" => response()->json($data, 200)->original];
        } else {
            return ["statusCode" => 400, "result" => response()->json("No records found", 400)->original];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileErr = "";
        $filesAllowed = array("jpg", "jpeg", "png");
        $userData = json_decode($request->input_data, true);
        $validator = Validator::make($userData, $this->rules, $this->messages);
        if ($request->has("employee_pic")) {
            $picture = $request->employee_pic;
            $fileExtension = strtolower($picture->getClientOriginalExtension());
            $fileName = $id . "." . $fileExtension;
            $fileSize = $picture->getSize();
            if (!(in_array($fileExtension, $filesAllowed))) {
                $fileErr = "Upload JPEG,JPG,PNG files";
            } else {
                if ($fileSize > 1000000) {
                    $fileErr = "Upload less than or equal to 1 MB";
                }
            }
        } else {
            $fileErr = "";
        }
        if (!$validator->fails() && $fileErr == "") {
            $path = public_path("own_files");
            $picture->move($path, $fileName);
            $emp = ModelsEmployee::find($id);
            $emp->employee_name = $userData['employee_name'];
            $emp->employee_email = $userData['employee_email'];
            $emp->employee_pic = $fileName;
            $emp->employee_pic_type = $picture->getClientMimeType();
            $result = $emp->save();
            if ($result) {
                return ["statusCode" => 201, "result" => response()->json("Successfully updated", 201)->original];
            } else {
                return ["statusCode" => 500, "result" => response()->json("Internal server error", 500)->original];
            }
        } else {
            return [
                "statusCode" => 400,
                "error" => ["employee_pic" => $fileErr, "data" => $validator->errors()]
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = ModelsEmployee::find($id);
        $filepath = $emp["employee_pic"];
        if (!empty($emp)) {
            if ($emp->delete()) {
                if (File::exists($filepath)) {
                    File::delete($filepath);
                }
                return ["statusCode" => 200, "result" => response()->json("Successfully deleted", 200)->original];
            } else {
                return ["statusCode" => 500, "result" => response()->json("Internal server error", 500)->original];
            }
        } else {
            return ["statusCode" => 400, "result" => response()->json("No records found to delete", 400)->original];
        }
    }
}
