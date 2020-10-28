@extends('layouts.master')
@section('title','Category')
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Title</h3>
                <div class="card-tools">
                    <button class="btn btn-info" data-toggle="modal" data-target="#addCategory">Add New</button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-hover datatable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($category as $key => $singleCategory)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $singleCategory["name"] }}</td>
                            <td>
                              <a href="javascript:void(0);" data-toggle="modal" data-target="#editCategory" class="btn btn-warning" onclick="getCategory('{{ $singleCategory['id'] }}','{{ $singleCategory['name'] }}');">Edit</a>
                              <a href="javascript:void(0);" onclick="deleteCategory('{{ $singleCategory['id'] }}');" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

      <!-- Modal -->
      <!-- Add Category Modal -->
      <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="" class="ajax_form_submit" method="post" action="{{ url('admin/add_new_category') }}">
                <div class="form-group">
                  <label>Category Name <span class="text-danger">*</span></label>
                  {{ csrf_field() }}
                  <input name="name" type="text" class="form-control" placeholder="Enter Category Name" required="required">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Category modal -->
      <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabeledit">Edit Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="editCategoryBody">
              <form id="" class="ajax_form_submit" method="post" action="{{ url('admin/edit_category') }}">
                <div class="form-group">
                  <label>Category Name <span class="text-danger">*</span></label>
                  {{ csrf_field() }}
                  <input type="hidden" name="EditcategoryId" id="EditcategoryId" value="">
                  <input name="name" id="editCategoryName" type="text" class="form-control" placeholder="Enter Category Name" value="" required="required">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

  </div>

<!-- Javascript -->
<script>

  function getCategory(categoryId, categoryName){
    $("#EditcategoryId").val(categoryId);
    $("#editCategoryName").val(categoryName);
  }

  // Delete Category
  function deleteCategory(categoryId){
      //BASE_URL is defined in master.blade.php
      var confirmit = confirm("Are you sure to delete this category!");
      if(confirmit){
          $.ajax({
          type: 'GET',
          url: BASE_URL+"/admin/delete_category",
          data: "categoryId="+categoryId,
          beforeSend: function(){
            
          },
          success: function(response){
            response = JSON.parse(response);
            alert(response.message);
            if(response.status != 'false'){
              window.location.href = response.reloadUrl;
            }
          },
          error: function(response){
            alert("Oops please try after some time!");
            window.location.href = "{{ url('admin/gallery_category') }}";
          }
        });
      }
  }

</script>

@endsection