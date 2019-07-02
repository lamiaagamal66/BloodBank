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
        $orderRequest = $request ->user()->orders()->create($request->all());//->load('cities.governorates' , 'blood_types'); // relation_name
        
       // dd($orderRequest);
        // find clients suitable for this order request
        $clientsIds = $orderRequest->cities->governorates->clients()
        ->whereHas('blood_types',function($q) use ($request,$orderRequest){
            $q->where('blood_types.name',$orderRequest->blood_type);
        }) -> pluck('clients.id')->toArray();

        // dd($clientsIds);
       
        if(count($clientsIds))
        {
            $notification = $orderRequest ->notifications()->creare([
                'title' => 'يوجد حالة تبرع قريبه منك ',
                'content' =>$orderRequest->bloodType . 'محتاج متبرع لفصيله ',
            ]);
            $notification->clients()->attach($clientsIds);

            $tokens = Token::whereIn('client_id' ,$clientsIds)->where('token' , '!=' , null)->pluck('token') ->toArray();
             if(count($tokens))
            {
               // public_path();
                $title = $notification->title;
                $body = $notification ->content;
                $data = [
                    'order_id' => $orderRequest->id
                ];
                $send = notifyByFirebase($title , $body , $tokens , $data);
                info("firebase result: " . $send);
            }
        }
        return responseJson( 1 ,  'تم الاضافه بنجاح ' , compact('orderRequest'));
    }


    // donationRequest
    public function order(Request $request)
    {
        $order = Order::where(function($query)use ($request){
            if($request->input('governorate_id')){
                $query->whereHas('cities',function($query)use ($request){
                    $query->where('governorate_id',$request->governorate_id);
                });
            }elseif($request->input('city_id')){
                $query->where('city_id',$request->city_id);
            }
            if($request->input('blood_type_id')){
                $query->where('blood_type_id',$request->blood_type_id);
            }
        })->with('cities','clients','blood_types')->latest()->paginate(10);
        
        return responseJson(1, 'success', $order);
        
    }

 
    // donationRequest
    public function orders(Request $request)
    {
        $orders= Order::all();
        return responseJson( 1 ,  'success' , $orders);
    }


    // <------------------ Posts Functions ----------->
    public function posts(Request $request)
    {
        $posts= Post::with('categories')->paginate(10);
        // $posts= Post::with('categories')->where(function($post) use($request){
        //     if($request->input('category_id'))
        //     {
        //         $post->where('category_id', $request->category_id);
        //         $post->whereHas('category' , function($category) use($request){
        //             $category->where('name' , 'like' , '%' .$request->keyword.'%');
        //         });
        //     }
        //     if($request->input('keyword'))
        //     {
        //         $post->where( function($post) use($request){
        //             $post->where('title', 'like' , '%' .$request->keyword.'%'); 
        //             $post->orwhere('content', 'like' , '%' .$request->keyword.'%');
        //         });
        //     }
        // })->oldest()->tosql(); //paginate(10)
        return responseJson( 1 ,  'success' , $posts);   
    }


    public function post($id)
    {
        $posts= Post::find($id);
        return responseJson( 1 ,  'success' , $posts);
    }


    // myFavourites
    public function myFavouritePosts(Request $request)
    {
        $posts = $request-> user() ->posts()->with('categories')->latest()->paginate(10);
        return responseJson( 1 ,  'success' , $posts);
    }


     // toggle-favourite
    public function postFavourite(Request $request)
    {
      //  RequestLog::create(['content'=>$request->all() , 'service'=> 'post togge favourite']);
        $rules = [ 'post_id'=> 'required|exists:post.id', ];
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
        $items = $request->user()->notifications()->latest()->paginate(20);
        return responseJson( 1 ,  'Loaded...' , $items);   
    }


    public function notificationsCount(Request $request)
    {
        $count = $request->user()->notifications()->where(function($query) use ($request){
            $query ->where('notification_is_read' , 0);
        })->count();
        return responseJson( 1 ,  'Loaded...' , ['notifications-count' =>$count] );   
    }


    public function testNotification(Request $request)
    {
           
    }


    public function settings()
    {
        return responseJson( 1 ,  'Loaded' , settings());   
    }


    public function contacts()
    {   
        $contacts= Contacts::all();
        return responseJson( 1 ,  'success' , $contacts); 
    }


    public function reports(Request $request)
    {
        // send sms to email verified in system 
      //  RequestLog::create(['content' => $request->all() , 'service' =>'contact us']);
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'subject'=>'required|max:100',
            'message'=>'required|min:3|max:1000',
        ];

        $validator = validator()->make($request->all(), $rules);
        if($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $user = Client::where('email',$request->email)->first();
        if($user)
        {
            $contact=Contacts::create($request->all());
            $contact->save();
            if ($contact){
                Mail::to("blood.bank740@gmail.com");
                   // ->send(new Contacts($contact));
                return responseJson(1, ' Check your mobile ',
                    [
                        'message' => $request->message,
                        'fails_mail' => Mail::failures(),
                        'email' => $contact->email,
                    ]);
            }else{
                return responseJson(0,  'حدث خطأ , حاول مرة أخرى');
            }
        } else {
        return responseJson(0,  'لا يوجد حساب مطابق للبيانات ');
        }
        
    }

}