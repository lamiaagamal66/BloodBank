<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'date_of_birth' => 'required',
            'last_donate' => 'required',
            'mobile' => 'required|string|max:15|regex:/[0-9]{10}/|digits:11|unique:clients',
            'password' => 'required|string|min:8|confirmed',
            'blood_type' => 'required|in:O+,O-,A+,A-,AB+,AB-,B+,B-',
            'city_id' => 'required',
           // 'api_token' => 'required',
        ]);

        if($validator->fails())
        {
            return responseJson( 0 , $validator->errors()->first() , $validator->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]);

        $client = Client::create($request->all());
        $client -> api_token = str_random(60);   
       // $client-> pin_code = rand(1111,9999);
        $client-> save();
        return responseJson( 1 , 'You are Successfully added.. ' , [
            'api_token' => $client -> api_token,
            'client' => $client,
           // 'pin_code' =>$client -> pin_code
        ]);
    }
    
            // login 
    public function login(Request $request)
    {
        $validator = validator()->make($request->all(),[
           
            'mobile' => 'required',
            'password' => 'required',
            
        ]);

        if($validator->fails())
        {
            return responseJson( 0 , $validator->errors()->first() , $validator->errors());
        }

       // return auth()->guard('api')->validate($request->all()); 
       $client = Client::where('mobile',$request->mobile)->first();

       if($client)
       {
           if(Hash::check($request->password , $client->password))
           {
                return responseJson( 1 , 'You are logged Successfully' , [
                    'api_token ' => $client -> api_token ,
                    'client' => $client
                ]);
           }else{
            return responseJson( 0 , 'Uncorrect information');
           }

       }else{
        return responseJson( 0 , 'Error information');
       }
    }


            // reset 
    public function resetPassword(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'mobile' => 'required',
        ]);
        
        if($validator->fails())
        {
            return responseJson( 0 , $validator->errors()->first() , $validator->errors());
        }
        
        $user = Client::where('mobile',$request->mobile)->first();
        if($user)
        {
            $code = rand(1111,9999);
            $update = $user->update(['pin_code' => $code]);
            if($update)
            {
                // send sms 
              //  smsMisr($request->mobile , "your reset code is : " . $code);

                // send Email 
                Mail::to($user->email)
                ->bcc("lamiaagamal4295@gmail.com") // mail of manager
                ->send(new ResetPassword($user));
        
                return responseJson( 1 , 'PLZ Check your messages', [
                    
                    'pin_code' =>$code,
                    'mail_fails' => Mail::failures(),
                    'email' => $user->email,
                    ]);
            
            }else{
                return responseJson( 0 , 'Warnning ! Try Again PLZ');
            }   
        }else{
         return responseJson( 0 , 'Error mobile number');
        }
        
    }   
    
    
    //password function
    public function newPassword(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'pin_code' => 'required' ,
          //  'mobile' => 'required' ,
            'password' => 'required|confirmed' ,
        ]);

        if($validator->fails())
        {
            $data = $validator->errors();
            return responseJson( 0 , $validator->errors()->first() , $data);
        }

        $user = Client::where('pin_code' , $request->pin_code)->where('pin_code' , '!=' ,0)
        ->first();

        if($user)
        {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if($user->save())
            {
                return responseJson( 1 , 'تم تغيير كلمة المرور بنجاح');
            } else {
                return responseJson( 0 , 'حدث خطأ ، حاول مره اخرى ');
            }

        } else{
            return responseJson( 0 , ' الكود خطأ ');
        }
    
    }


    public function profile(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'date_of_birth' => 'required',
            'last_donate' => 'required',
            'mobile' => 'required|string|max:15|regex:/[0-9]{10}/|digits:11',
            'password' => 'required|string|min:8|confirmed',
            'blood_type' => 'required|in:O+,O-,A+,A-,AB+,AB-,B+,B-',
            'city_id' => 'required',
           // 'api_token' => 'required',  
        ]);

       if($validator->fails())
       {
           $data = $validator->errors();
           return responseJson( 0 , $validator->errors()->first() , $data);
       }

       $loginUser = $request->user();
       $loginUser->update($request->all());
       if($request->has('password'))
       {
           $loginUser->password = bcrypt($request->password);
       }

       $loginUser->save();
       $data = [ 'clients' => $request->user()->fresh()->load('city.governorate' , 'blood_types')];
       return responseJson( 1 , 'تم تحديث البيانات ' , $data);
    }


    public function registerToken(Request $request)
    {
        $validator = validator()->make($request->all() ,[
            'token' => 'required',
            'type' => 'required|in:android,ios',
        ]);

        if($validator->fails())
        {
            $data = $validator->errors();
            return responseJson( 0 , $validator->errors()->first() , $data);
        }

        Token::where('token' , $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson( 1 ,  'تم التسجيل بنجاح ');
    }


    public function removeToken(Request $request)
    {
       $validator = validator()->make($request->all() , [
           'token' => 'required' ,
        ]);

        if($validator->fails())
        {
            $data = $validator->errors();
            return responseJson( 0 , $validator->errors()->first() , $data);
        }

        Token::where('token' , $request->token)->delete();
        return responseJson( 1 , 'تم الحذف بنجاح ');
    }
 


    public function notificationsSettings(Request $request)
    {
      // RequestLog::create(['content' => $request->all() , 'service' =>'Notifications Settings']);
       $rules = [
            'governorates.*' => 'exists:governorates,id' ,
            'blood_types.*' => 'exists:blood_types,id' ,
       ];

       $validator = validator()->make($request->all() , $rules);
       if($validator->fails())
       {
           return responseJson( 0 , $validator->errors()->first() , $validator->errors());
       }

       if($request->has('governorates'))
       {
            $request->user()->governorates()->sync($request->governorates);
       }

       if($request->has('blood_types'))
       {
            $request->user()->blood_types()->sync($request->blood_types);
       }

       $data = [
        'governorates' => $request->user()->governorates()->pluck('governorates.id')->toArray(),
        'blood_types' => $request->user()->blood_types()->pluck('blood_types.id')->toArray(),
       ];

        return responseJson( 1 , 'تم التحديث' , $data);
    
    }


                
}