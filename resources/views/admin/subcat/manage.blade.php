@extends('admin.master.master')
@section('title')
Dashboard
@endsection


@section('body')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title-box">
                                <h4 class="font-size-18">Product Child Category</h4>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Resnova</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Product and Services</a></li>
                                    <li class="breadcrumb-item active">Product Child Category</li>
                                </ol>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                            @if (Auth::guard('admin')->user()->can('subcategory.create'))
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg" type="button">
                                        <i class="far fa-calendar-plus  mr-2"></i> Add New Category
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Parent Category Name</th>
                                                <th>Child Category Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                        @foreach ($subcategories as $role) 
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $role->category_slug }}</td>
                                                <td>{{ $role->subcategory_name }}</td>
                                                <td>
                                       @if($role->status == 1)

Active

                                      @else
Inactive

                                      @endif
                                    </td>
                                                <td>
                                                    <div class="btn-group">
                                                    @if (Auth::guard('admin')->user()->can('subcategory.edit'))
                                                        <a href="{{ route('admin.subcategory.edit', $role->id) }}" 
                                                        type="button" class="btn btn-primary waves-light waves-effect"><i class="fas fa-pencil-alt"></i></a>
                                                        @endif

                                                        @if (Auth::guard('admin')->user()->can('subcategory.delete'))
                                                        <button type="button" onclick="deleteTag({{ $role->id}})" class="btn btn-danger waves-light waves-effect">
                                                        <i class="far fa-trash-alt"></i></button>
                                                        <form id="delete-form-{{ $role->id }}" action="{{ route('admin.subcategory.destroy',$role->id) }}" method="POST" style="display: none;">
                     
                     @csrf
                     
                 </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                         @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->



                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!--  Modal content for the above example -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Add New Child Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="custom-validation" action="{{ route('admin.subcategory.store') }}" method="post">
                            @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label>Parent Category</label>
                                                    <select class="form-control" name="category_slug">
                                                        <option>Select</option>
                                                        @foreach($categories as $newcat)                     
                <option value="{{ $newcat->category_slug }}">{{ $newcat->category_name }}</option>
               @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group ">
                                                    <label>Child Category Name:</label>
                                                    <input type="text" class="form-control" name="subcategory_name"/>
                                                </div>

                                                <div class="form-group ">
                                <label for="password">Status</label>
                                <select name="status" id="roles" class="form-control">
                                    
                <option value="1">Active</option>
                <option value="0">InActive</option>
                                   
                                </select>
                            </div>

                                            </div>
                                        </div>

                                    </div> <!-- end col -->


                                    <div class="col-lg-12">
                                        <div class="float-right d-none d-md-block">
                                            <div class="form-group mb-4">
                                                <div>
                                                    <button type="submit" class="btn btn-primary btn-lg  waves-effect waves-light mr-1">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            @endsection


            @section('scripts')
     <script>
         /**
         * Check all the permissions
         */
         $("#checkPermissionAll").click(function(){
             if($(this).is(':checked')){
                 // check all the checkbox
                 $('input[type=checkbox]').prop('checked', true);
             }else{
                 // un check all the checkbox
                 $('input[type=checkbox]').prop('checked', false);
             }
         });
         function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');
            if(groupIdName.is(':checked')){
                 classCheckBox.prop('checked', true);
             }else{
                 classCheckBox.prop('checked', false);
             }
         }
     </script>

      <script type="text/javascript">
        function deleteTag(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script> 

    @endsection