<x-header-component />
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date of birth</th>
                                <th>Profile</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($studentData))
                            @foreach($studentData as $list)
                            <tr>
                                <td>{{ $list -> full_name }}</td>
                                <td>{{ $list -> dob }}</td>
                                <td> <img src="data:{{ $list -> profile_pic_type }};base64, {{ asset('storage/ $list -> profile_pic') }}" class="img-thumnail" /> </td>
                                <td>
                                    <a class="btn btn-info" href="edit-student/{{ $list -> student_id }}">EDIT</a>
                                    ||
                                    <a class="btn btn-danger" href="delete-student/{{ $list -> student_id }}">DELETE</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" align="center">No records found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<x-footer-component />