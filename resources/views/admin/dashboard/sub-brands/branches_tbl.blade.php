<h5><i class="fas fa-link"></i>Branches</h5>
<div class="col-12">
    <button type="button" id="mydeletebtn" class="btn btn-danger getDeleteGroup mb-3 mt-3" >
        <i class="fas fa-trash-alt"></i>
    </button>
</div>
<div class="col-12">
    <table class="table table-striped" id="table_branches" data-branches="{{isset($branchesHandel)?$branchesHandel:''}}">
        <thead class="">
        <tr>
            <th scope="col">
                <input type="checkbox" id="select_all"  name="select_all" />
            </th>
            <th scope="col">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Country</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @isset($branchesHandel)
            @foreach(json_decode($branchesHandel) as $branch)
{{--                @dd($branch)--}}
                <tr id='row-{{$branch->_id}}'>
                    <td><input type="checkbox"  name="ids[]" value='{{$branch->_id}}' /></td>
                    <td>{{$branch->name}}</td>
                    <td>{{$branch->city}}</td>
                    <td>{{$branch->country_name}}</td>
                    <td>
                        @if($branch->status==1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">InActive</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" data-toggle="modal" data-target="#branchModal" class="btn btn-warning edit_branch" onclick='editBranch("{{$branch->_id}}")'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button"  class="btn btn-danger delete_branch" onclick='deleteBranch("{{$branch->_id}}")'>
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
</div>

@section('js')
<script>
    let branches = $('#table_branches').data('branches');
</script>
<script src="{{asset('js/influencer/branches_crud.js')}}"></script>
@endsection
