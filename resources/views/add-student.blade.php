<x-header-component data="" />
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">
                    <b class="text-success">
                        @if(!empty($data))
                        {{ $data }}
                        @endif
                    </b>
                </h5>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="defaultFormControlInput" class="form-label">Name</label>
                                <input type="text" class="form-control" name="student_name" id="student_name" placeholder="John Doe" value="{{old ('student_name') }} " />
                                <div id="defaultFormControlHelp" class="form-text text-danger">
                                    @error("student_name"){{ $message }}@enderror
                                </div>
                                <label for="defaultFormControlInput" class="form-label">DOB</label>
                                <input type="date" class="form-control" name="student_dob" id="student_dob" value=" {{old ('student_dob') }} " />
                                <div id="defaultFormControlHelp" class="form-text text-danger">
                                    @error("student_dob"){{ $message }}@enderror
                                </div>
                                <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
                            </div>
                            <div class="col-lg-6">
                                <label for="defaultFormControlInput" class="form-label">File</label>
                                <input class="form-control" type="file" id="pro_pic" name="pro_pic" />
                                <div id="defaultFormControlHelp" class="form-text text-danger">
                                    @error("pro_pic"){{ $message }}@enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Content -->
<x-footer-component />