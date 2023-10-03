<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\product;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Replay;
use Session;
use Stripe;



class HomeController extends Controller
{
    public function index(){
        $product = product::paginate(10);
        $comment=comment::orderby('id','desc')->get();
        $replay=replay::all();
        return view('home.userpage',compact('product','comment','replay'));
    }
    public function redirect(){

        $usertype=Auth::user()->usertype;
        if ($usertype=='1'){
            $total_product=product::all()->count();
            $total_order=order::all()->count();
            $total_user=user::all()->count();
            $order=order::all();
            $total_revenue=0;
            foreach($order as $order){
                $total_revenue=$total_revenue+ $order->price;

            }
            $total_delivered=order::where('delivery_status','=','delivered')->get()->count();
            $total_processing=order::where('delivery_status','=','processing')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_delivered','total_processing'));
        }
        else{
            $product = product::paginate(10);
            $comment=comment::orderby('id','desc')->get();
            $replay=replay::all();
            return view('home.userpage',compact('product','comment','replay'));
        }
    }
    public function product_details($id){
        $product=product::find($id);

        return view('home.product_details', compact('product'));
    }
    public function add_cart(Request $request, $id){
        if(auth::id()){
            $user= Auth::user();
            $userid=$user->id;
            $product= product::find($id);
            $product_exist_id=cart::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();
            if($product_exist_id){
                $cart=cart::find($product_exist_id)->first();
                $quantity=$cart->quantity;
                $cart->quantity+=$request->quantity;
                if($product->discount_price!=null)
                {
                    $cart->price=$product->discount_price *$cart->quantity;
                }
                else{
                $cart->price=$product->price *$cart->quantity;
                }
                $cart->save();
                return redirect()->back()->with('message','Product Added Successfully');

            }else{
                $cart=new Cart();
                $cart->name= $user->name;
                $cart->email= $user->email;
                $cart->address=$user->address;
                $cart->user_id=$user->id;
                $cart->product_title=$product->title;
                if($product->discount_price!=null)
                {
                    $cart->price=$product->discount_price *$request->quantity;
                }
                else{
                $cart->price=$product->price *$request->quantity;
                }
                $cart->image=$product->image;
                $cart->product_id=$product->id;
                $cart->quantity=$request->quantity;
                $cart->save();
                return redirect()->back()->with('message','Product Added Successfully');
                
            }

        }
        else{
            return redirect ('login');
        }
    }
    public function show_cart(){
        if(Auth::id()){
            $id=Auth::user()->id;
            $cart= Cart::where('user_id','=',$id)->get();
            return view('home.show_cart',compact('cart'));
        }
        else{
            return redirect('login');
        }

    }
    public function remove_cart($id){
        $cart=Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }
    public function cash_order(){
        $user=Auth::user();
        $userid=$user->id;
        $data=cart::where('user_id','=',$userid)->get();
        foreach($data as $data){
            $order=new Order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_title=$data->product_title;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;
            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';
            $order->save();

            $cart_id=$data->id;
            $cart=Cart::find($cart_id);
            $cart->delete();

        }
        return redirect()->back()->with('message','we have received your order we will connect you soon');
    }
    public function stripe($totalprice)
    {
        return view('home.stripe',compact('totalprice'));
    }
   
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request, $totalprice)

    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
    
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for Payment.",
                ]); 
            $user=Auth::user();
            $userid=$user->id;
             $data=cart::where('user_id','=',$userid)->get();
             foreach($data as $data){
            $order=new Order;
            $order->name=$data->name;
            $order->email=$data->email;
            $order->phone=$data->phone;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_title=$data->product_title;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;
            $order->payment_status='Paid';
            $order->delivery_status='processing';
            $order->save();

            $cart_id=$data->id;
            $cart=Cart::find($cart_id);
            $cart->delete();

        }
        Session::flash('success', 'Payment successful!');
        return back();
    
    }
    public function show_order(){
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $order=order::where('user_id','=',$userid)->get();
          return view('home.order',compact('order'));
        }
        else{
            return redirect('login');
        }
    }
    public function cancel_order($id){
        $order=order::find($id);
        $order->delivery_status='You cancel the order';
        $order->save();
        return redirect()->back();

    }
    public function add_comment(request $request){
        if(auth::id()){
            $comment=new comment;
            $comment->name=auth::user()->name;
            $comment->user_id=auth::user()->id;
            $comment->comment=$request->comment;
            $comment->save();
            return redirect()->back();

        }
        else{
            return redirect('login');
        }
    }
    public function add_replay(request $request){
        if(auth::id()){
            $replay=new replay;
            $replay->name=auth::user()->name;
            $replay->user_id=auth::user()->id;
            $replay->comment_id=$request->commentId;
            $replay->replay=$request->replay;
            $replay->save();
            return redirect()->back();

        }
        else{
            return redirect('login');
        }

    }
    public function product_search(request $request){
        $search_text=$request->search;
        $comment=comment::orderby('id','desc')->get();
        $replay=replay::all();
        $product=product::where('title','LIKE',"%$search_text%")->orwhere('catagory','LIKE',"$search_text")->paginate(10);
        return view('home.userpage',compact('product','comment','replay'));
    }
    public function products(){
        $product = product::paginate(10);
        $comment=comment::orderby('id','desc')->get();
        $replay=replay::all();
        return view('home.all_product',compact('product','comment','replay'));
    }
    public function search_product(request $request){
        $search_text=$request->search;
        $comment=comment::orderby('id','desc')->get();
        $replay=replay::all();
        $product=product::where('title','LIKE',"%$search_text%")->orwhere('catagory','LIKE',"$search_text")->paginate(10);
        return view('home.all_product',compact('product','comment','replay'));
    }
}
