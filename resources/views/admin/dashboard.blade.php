@extends('layouts.master')
@section('title','Dashboard')
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Gallery</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
              <li class="breadcrumb-item active">Gallery</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Image Gallery</h3>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-4 border">
                    <div class="text-center my-2"><h3>Gallery Categories</h3></div>
                    <div id="categoryDiv">
                        <nav class="mt-2">
                          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                          @foreach($category as $key => $singleCategory)
                            <li class="nav-item">
                              <a href="javascript:void(0);" class="nav-link makeActiveInactive" onclick="getImagesByCategory('{{ $singleCategory['name'] }}');makeActiveInactiveCategory(this);">
                                <p>{{ $singleCategory["name"] }}</p>
                              </a>
                            </li>
                          @endforeach
                          </ul>
                        </nav>
                    </div>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-8 border">
                    <div class="text-center my-2"><h3 id="categoryTitle">Images</h3></div>
                      <div id="flickerImagesDiv" class="overflow-auto">
                          <div class="alert alert-info text-center mt-4"><h5>Select category from left to see images here.</h5></div>
                      </div>
                      <div id="singleImageView" class="my-2 d-none">
                          <div class="row">
                            <div class="col-md-7">
                              <img id="setImageSrc" width="100%" height="500px" class="rounded" src="">
                            </div>
                            <div class="col-md-5">
                              <div class="my-2 mt-3">
                                  <span class="h3">Image Details</span>
                                  <button class="btn btn-primary float-right" onclick="goBack();"><i class="fa fa-angle-left" aria-hidden="true"></i> Go Back</button>
                              </div>
                              <div class="mt-4" id="imageDescription">

                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                </div>

              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    
   
  </div>
  <!-- Javascript -->
  <script>
      function makeActiveInactiveCategory(ele){ 
        $('.makeActiveInactive').removeClass('active'); $(ele).addClass('active');
      }
      function getImagesByCategory(categoryName){
        $("#flickerImagesDiv").removeClass("d-none");
        $("#singleImageView").addClass("d-none");
          $("#categoryTitle").text(categoryName+' photo gallery');
          var flickerAPI = "https://api.flickr.com/services/feeds/photos_public.gne?format=json&tags=" + categoryName;
          $("#flickerImagesDiv").html("");
          $.ajax({
              url: flickerAPI,
              dataType: "jsonp", 
              jsonpCallback: 'jsonFlickrFeed',
              beforeSend: function(){
                $("#flickerImagesDiv").html('<div class="text-center mt-4"><i class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i></div>');
              },
              success: function (result, status, xhr) {
                  // console.log(result);
                  $("#flickerImagesDiv").html("");
                  var imageString = "<div class='row'>";
                  var descriptionEncoded = "";
                  $.each(result.items, function (i, item) {
                      if (i === 12) {
                          return false;
                      }
                      // descriptionEncoded = encodeURI(item.description);;
                      imageString += '<div class="col-md-4 my-2">';
                      imageString += '<a href="javascript:void(0);" class="" onclick="showImage(\''+categoryName+'\', \''+item.media.m+'\', \''+item.tags+'\');">';
                      imageString += '<img width="100%" height="200px" class="rounded" src="' + item.media.m + '"></a></div>'; 
                  });
                  imageString += '</div>';
                  $("#flickerImagesDiv").html(imageString);
              },
              error: function (xhr, status, error) {
                  console.log(xhr)
                  $("#flickerImagesDiv").html("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
              }
          });
      }

      function showImage(categoryName, imgSrc, description){
        // var description = decodeURI(description);
        $("#flickerImagesDiv").addClass("d-none");
        $("#singleImageView").removeClass("d-none");
        $("#categoryTitle").text(categoryName+' photo gallery');
        $("#setImageSrc").prop('src', imgSrc);
        $("#imageDescription").html(description);
      }

      function goBack(){
        $("#flickerImagesDiv").removeClass("d-none");
        $("#singleImageView").addClass("d-none");
      }
  </script>
  @endsection