@extends('layouts.app')

@section('content')
<div class="">
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-12"> --}}
    <div class="card">
        <div class="card-header">{{ __('MY PROJECTS DASHBOARD') }}</div>
        <div class="card-body">
            <table id="projectTable" class="table table-condensed table-bordered table-striped">
                <thead>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Assigned</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Function</th>
                </thead>
                <tbody>
                    @foreach ($projects as
                    $key=>$item)
                    <tr>
                        <td>{{$key +1}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->assigned == 0 ? 'None' : \Illuminate\Support\Facades\DB::table('users')->where('id', $item->assigned)->value('name') }}
                        </td>
                        <td>{{ Substr($item->description, 0,15 )}}..</td>
                        <td>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</td>
                        <td>
                            {{-- if picked hide --}}
                            @if ($item->assigned == 0)
                            <a href="#" class="btn btn-sm btn-info pick" id="{{$item->id}}"><i class="fa fa-check"></i> Pick</a>
                            @endif
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary btn-sm editProject" id="{{$item->id}}">
                                <i class="fa fa-edit"></i> status
                            </button>
                            {{-- <a href="#" id="{{$item->id}}" class="btn btn-outline-danger btn-sm trash">
                                <i class="fa fa-trash"></i> Trash
                            </a> --}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Assigned</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Function</th>
                </tfoot>
            </table>
        </div>
    </div>
    {{-- </div> --}}
    {{-- </div> --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="editProjectForm" class="editProjectForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="editTitle" class="col-md-3 col-form-label text-md-right">Project
                                Status</label>
                            <div class="col-md-9">
                                <select name="status" id="status"class="form-control">
                                    <option value="pending">Pending</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Complete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i
                                class="fa fa-times"></i> Close</button>
                        <button type="submit" id="" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i>
                             Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" defer></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.0/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready( function () {
        $('#projectTable').DataTable();

// get project
        $('.editProject').on('click', function(){
            var proj_id = $(this).attr('id');
            console.log($(this).attr('id'))
            // get the project details
            $.ajax({
                type: 'GET',
                url: '/project/'+proj_id,
                success: function(res){
                    $('#editModal').modal('toggle');
                    $("#status").val(res.status).change();
                    $("<input/>").attr("type", "hidden")
                    .attr("name", "update_project_id")
                    .attr("id", "update_project_id")
                    .attr("value", proj_id)
                    .appendTo("#editProjectForm");
                }
            });
        });
        // update project
        $('#editProjectForm').on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                url: '/project/status/'+$('#update_project_id').val(),
                type: 'post',
                dataType: 'json',
                cache: false,
                data: $(this).serialize(),
                success: function (resp) {
                    $('#editProjectForm')[0].reset();
                    $('#editModal').modal('toggle');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: resp.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        reload();
                },
                error: function(err){
                    console.log(err)
                }
            });
        });
        function reload() {
            setTimeout(() => {
                location.reload();
            }, 3000);
        }
    } );
</script>
@endsection
