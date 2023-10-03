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
              <form action="{{url('/update_product_confirm',$product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="div-design">
                <label for="">Product Title :</label>
                <input class="text_color" required="" value="{{$product->title}}" type="text" name="title" placeholder="enter title">
            </div>
            <div class="div-design">
                <label for="">Product Description :</label>
                <input class="text_color" type="text" value="{{$product->description}}" required="" name="description" placeholder="enter description">
            </div>
            <div class="div-design">
                <label for="">Product Price :</label>
                <input class="text_color" type="number" value="{{$product->price}}" required="" name="price" placeholder="enter price">
            </div>
            <div class="div-design">
                <label for="">Discount Price :</label>
                <input class="text_color" type="number" value="{{$product->discount_price}}" name="dis_price" placeholder="enter discount">
            </div>

            <div class="div-design">
                <label for="">Product Quantity :</label>
                <input class="text_color"  required="" type="number" value="{{$product->quantity}}"  name="quantity" placeholder="enter quantity">
            </div>
            <div class="div-design">
                <label for="">Product Catagory :</label>
                <select class="text_color"  required="" name="catagory">
                <option value="{{$product->title}}" selected="">{{$product->title}}</option>
                @foreach($catagory as $catagory)
                  <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="div-design">
                <label for="">Current Product Image  :</label>
                <img style="margin: auto;" width="100" height="100" src="/product/{{$product->image}}" alt="">
            </div>
            <div class="div-design">
                <label for="">Change Product Image  :</label>
                <input type="file" name="image" >
            </div>
            <div class="div-design">
              <input type="submit" name="" value="Update Product" class="btn btn-primary">
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