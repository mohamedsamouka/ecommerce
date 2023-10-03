<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        label{
            display: inline-block;
            font-size: 15px;
            font-weight: bold;
            text-align: center; 
            width: 200px;
        }
        .text_color{
            color: black;
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
                <h1 style="text-align: center; font-size: 25px;">Send Email to {{$order->email}}</h1>
                <form action="{{url('send_user_email',$order->id)}}" method="POST">
                    @csrf
                <div style="padding-left:35%; padding-top:30px;">
                    <label for="">Email Greeting :</label>
                    <input class="text_color" type="text" name="greeting">
                </div>
                <div style="padding-left:35%; padding-top:30px; ">
                    <label for="">Email Firstline :</label>
                    <input class="text_color" type="text" name="firstline">
                </div>
                <div style="padding-left:35%; padding-top:30px;">
                    <label for="">Email Body :</label>
                    <input class="text_color" type="text" name="body">
                </div>
                <div style="padding-left:35%; padding-top:30px;">
                    <label for="">Email Button name :</label>
                    <input class="text_color" type="text" name="button">
                </div>
                <div style="padding-left:35%; padding-top:30px;">
                    <label for="">Email Url :</label>
                    <input class="text_color" type="text" name="url">
                </div>
                <div style="padding-left:35%; padding-top:30px;">
                    <label for="">Email Lastline :</label>
                    <input class="text_color" type="text" name="lastline">
                </div>
                <div style="padding-left:53%; padding-top:30px;">
                    <input type="submit" style="padding-right:45px; width:220px; padding-left:45px;" value="Send Email" class="btn btn-primary">
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