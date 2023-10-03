<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
     .div_center{
        text-align: center;
        padding-top: 40px;
    }
    .font_size{
      font-size: 40px;
      padding-bottom: 40px;
    }
    .text_color{
      color: black;
      padding-bottom: 20px;
    }
    label{
      display: inline-block;
      width: 200px;
      text-align: center;
    }
    .div-design{
      padding-bottom: 15px;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
     @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          @if (session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close"  data-dismiss="alert"  aria-hidden="true">x</button>
              {{session()->get('message')}}
            </div>

            @endif
            <div class="div_center">
            <h1 class="font_size">Add Product</h1>
              <form action="{{url('/add_product')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="div-design">
                <label for="">Product Title :</label>
                <input class="text_color" required="" type="text" name="title" placeholder="enter title">
            </div>
            <div class="div-design">
                <label for="">Product Description :</label>
                <input class="text_color" type="text"  required="" name="description" placeholder="enter description">
            </div>
            <div class="div-design">
                <label for="">Product Price :</label>
                <input class="text_color" type="number" required="" name="price" placeholder="enter price">
            </div>
            <div class="div-design">
                <label for="">Discount Price :</label>
                <input class="text_color" type="number" name="dis_price" placeholder="enter discount">
            </div>

            <div class="div-design">
                <label for="">Product Quantity :</label>
                <input class="text_color"  required="" type="number"  name="quantity" placeholder="enter quantity">
            </div>
            <div class="div-design">
                <label for="">Product Catagory :</label>
                <select class="text_color"  required="" name="catagory">
                <option value="" selected="">Add catagory here</option>
                  @foreach($catagory as $catagory)
                  <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="div-design">
                <label for="">Product Image Here :</label>
                <input type="file" name="image"  required="">
            </div>
            <div class="div-design">
              <input type="submit" name="" value="Add Product" class="btn btn-primary">
            </div>
              </form>

          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>