<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Models\Governorate;
use App\Models\City;
use App\Models\Post;
use App\Models\Category;
use App\Models\Client;
use App\Models\BloodType; //
use App\Models\Setting; // 
use App\Models\Clientables; //
use App\Models\Contacts;
use App\Models\Notification;
use App\Models\Order;
use App\Models\RequestLog;
use App\Models\Token;
use DB;

 
class MainController extends Controller
{
    public function logs()
    {
        $requests = RequestLog::latest()->paginate(50);
        return $requests; 
    }


    public function governorates()
    {
        $governorates= Governorate::all();
        return responseJson( 1 ,  'success' , $governorates);     
    }


    public function cities(Request $request)
    {
        /* if there in no paramter return empty 
        $cities= City::where('governorate_id',$request->governorate_id)->get(); 
        */
        // if there is no param return all ..
        $cities= City::where(function ($query) use ($request){
            if($request->has('governorate_id'))
            {
              $query->where('governorate_id',$request->governorate_id);
            }
        })->get();
        return responseJson( 1 , 'success' , $cities);    
    }


    public function categories()
    {
        $categories= Category::all();
        return responseJson( 1 ,  'success' , $categories);    
    }


    public function bloodTypes()
    {
        $blood_types= BloodType::all();
        return responseJson( 1 ,  'success' , $blood_types);
    } 
   

    // <------------------ orders (donationRequests) Functions ----------->
    // donationRequestCreate
    public function orderCreate(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required|string|max:255',
            'age' => 'required:digits',
            'blood_type' => 'required|in:O+,O-,A+,A-,AB+,AB-,B+,B-',
            'quantity' => 'required:digits',
            'hospital_name' => 'required',
            'hospital_address' => 'required',
            'city_id' =>'required|exists:cities,id',
            
            'mobile' => 'required|string|max:15|regex:/[0-9]{10}/|digits:11',     
        ]); 
        if($validator->fails())
        {
            return responseJson( 0 , $validator->errors()->first() , $validator->errors());
        }
        $orderRequest = $request ->user()->orders()->create($request->all());
        
       // dd($orderRequest);
        // find clients suitable for this order request
        $clientsIds = $orderRequest->city->governorate->clients()
        ->whereHas('blood_types',function($q) use ($request,$orderRequest){
            $q->where('blood_types.name',$orderRequest->blood_type);
        }) -> pluck('clients.id')->toArray();

         //dd($clientsIds);
       
        if(count($clientsIds))
        {
            $notification = $orderRequest ->notifications()->create([
                'title' => 'يوجد حالة تبرع قريبه منك ',
                'content' =>$orderRequest->blood_type . 'محتاج متبرع لفصيله ',
            ]);
            $notification->clients()->attach($clientsIds);

            $tokens = Token::whereIn('client_id' ,$clientsIds)->where('token' , '!=' , null)->pluck('token') ->toArray();
           // dd($tokens);
             if(count($tokens))
            {
                $title = $notification->title;
                $body = $notification ->content;
                $data = [
                    'order_id' => $orderRequest->id
                ];
                $send = notifyByFirebase($title , $body , $tokens , $data);
                info("firebase result: " . $send);
               // dd($send);
            }
        }
        return responseJson( 1 ,  'تم الاضافه بنجاح ' ,$orderRequest );
    }


    // donationRequest
    public function orders(Request $request)
    {
        $orders = Order::where(function($query)use ($request){
            if($request->has('governorate_id')){
                $query->whereHas('city',function($query)use ($request){
                    $query->where('governorate_id',$request->governorate_id);
                });
            }elseif($request->has('city_id')){
                $query->where('city_id',$request->city_id);
            }

            if($request->has('blood_type_id')){
                $query->where('blood_type_id',$request->blood_type_id);
            }
        })->with('city','client','blood_type')->latest()->paginate(10);
        
        return responseJson(1, 'success', $orders);
        
    }

 
    // donationRequest
    public function order(Request $request)
    {
        $order= Order::with('city' , 'client' ,'blood_type')->find($request->order_id);

        if(!$order) {
            return responseJson( 0 ,  'Your Request Not Found..');
        }

        if($request->user()->notifications()->where( 'order_id' ,$order->id)->first())
        {
            $request->user()->notifications()->updateExistingPivot($order->notification->id , [
                'notification_is_read' => 1
                ]);    
        }
       
        return responseJson( 1 ,  'success' , $order);
    }


    // <------------------ Posts Functions ----------->
    public function posts(Request $request)
    {
      //$posts= Post::with('categories')->paginate(10);

        $posts= Post::with('category')->where(function($query) use($request){
            if($request->has('category_id'))
            {
                $query->where('category_id', $request->category_id);
            }
            if($request->has('keyword'))
            {
            $query->where( function($post) use($request){
               $post->where('title', 'like' , '%' .$request->keyword.'%');
               $post->orwhere('content', 'like' , '%' .$request->keyword.'%');
            });
            }    
        })->latest()->paginate(10); //
        return responseJson( 1 ,  'success' , $posts);   
    }


    public function post(Request $request)
    {
        $post= Post::with('category')->find($request->post_id);
        if(!$post) {
            return responseJson( 0 ,  'Your Post Not Found..');
        }
        return responseJson( 1 ,  'success' , $post);
    }


    // myFavourites
    public function myFavouritePosts(Request $request)
    {
        $posts = $request-> user() ->posts()->with('category')->latest()->paginate(10);
        return responseJson( 1 ,  'success' , $posts);
    }


     // toggle-favourite
    public function postToggleFavourite(Request $request)
    {
      //  RequestLog::create(['content'=>$request->all() , 'service'=> 'post togge favourite']);
        $rules = [ 'post_id'=> 'required|exists:posts,id', ];
        $validator = validator()->make($request->all() , $rules); 
        if($validator->fails())
        {
            return responseJson( 0 ,  $validator->errors()->first() , $validator->errors());
        }
        $toggle = $request->user()->posts()->toggle($request->post_id);
        return responseJson( 1 ,  'success' , $toggle);
    }

    
    // <------------------ Notifications Functions ----------->
    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return responseJson( 1 ,  'Loaded...' , $notifications);   
    }


    public function notificationsCount(Request $request)
    {
        $count = $request->user()->notifications()->where(function($query) use ($request){
            $query ->where('notification_is_read' , 0);
        })->count();
        return responseJson( 1 ,  'Loaded...' , ['notifications-count' =>$count]);   
    }

    public function settings()
    {
        return responseJson( 1 ,  'Loaded' , settings());   
    }


    public function contactReports(Request $request)
    {
        // send sms to email verified in system 
      //  RequestLog::create(['content' => $request->all() , 'service' =>'contact us']);
        $rules = [
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'phone'=>'required|string|max:15|regex:/[0-9]{10}/|digits:11',
            'subject'=>'required|max:100',
            'message'=>'required|min:3|max:1000',
        ];

        $validator = validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $contact=Contacts::create($request->all());
        
        if ($contact){
            //  Mail::to("blood.bank740@gmail.com")
            // ->bcc("lamiaagamal4295@gmail.com") ;// mail of manager
            //->send(new Contacts($contact));

            return responseJson(1,  'شكرا على تسجيل شكوتك' , $contact);
            
        }else{
            return responseJson(0,  'حدث خطأ , حاول مرة أخرى');
        }
        
    }

}