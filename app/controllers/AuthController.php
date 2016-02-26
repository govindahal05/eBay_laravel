<?php
use Libraries\Validations\Validator;
use Library\UserInterface as User;
use Illuminate\Http\Request;
class AuthController extends BaseController
    {
            public function __construct(Validator $validator, User $user, Request $request)
            {
                $this->validator = $validator;
                $this->user = $user;
                $this->request = $request;
            }
        
         public function login()
         {
            $username = \Input::get('username');
            $password = \Input::get('password');
            
            $user_authentication = Auth::attempt([
                'username' => $username,
                'password' => $password
            ]);
            if ($user_authentication)
            {   
                if($username=='admin')
                {
                    return Redirect::route('admin');
                }
                else
                {
                        //$users= User::where('username','=',$username)->get();
                        
                    Session::put('username', $username);
                    return Redirect::route('member');
                        
                            
                }
                        // $logged_user=Session::get('first_name')." ".Session::get('last_name');
                        // return View::make('user/userdashboard')->with('auth_user',$logged_user);
            }
            else 
            {
                return Redirect::back()->with(['message' => 'Unauthorized Access']);
             }
        }
        public function logout()
        {
            Session::flush();
             return View::make('frontend');
        }
    public function gotoadmin()
    {
        return View::make('admin/admin_dashboard');
    } 
    public function gotomember()
    {
        return View::make('members/member_dashboard');
    }
    
    public function showLogin()
    {
        return View::make('frontend');
    }

    public function register()
    {
        // $fname=\Input::get('fname');
        // $lname=\Input::get('lname');
        // $email=\Input::get('email');
        // $username=\Input::get('username');
        // $password=\Input::get('password');
          $data = $this->request->all();
          $rules = array(
            'email' => 'unique:users,email',
            'username'=>'unique:users',
            'password' => 'min:4|max:10'
            );
         $validation = $this->validator->validate($data, $rules);
        // $validator= Validator::make([
            
        //  'email'=> $email,
        //  'username'=> $username,
        //  'password'=>$password,
        //  ],
        //  [
        //  'email' => 'unique:users,email',
        //  'username'=>'unique:users',
        //  'password' => 'min:4|max:10'
        //  ]);
    if ($validation === true) {
       $user =  $this->user->create(
           array(
               'full_name'      => $data['name'],
               'address'      => $data['address'],
               'phone'      => $data['phone'],
               'email'      => $data['email'],
               'gender'      => $data['gender'],
               'username'      => $data['username'],
               'password'   => Hash::make($data['password']),
               )
           );
       Session::flash('message', "Account Successfully Created");
            return Redirect::back();
    }
        // if ($validator->fails()) {
        //  return Redirect::back()->withInput()->withErrors($validator);
    //       }
    //       else
    //       {
    //               User::create([
    //               'first_name'=>$fname,
    //               'last_name'=>$lname,
    //               'email'=>$email,
    //               'username'=>$username,
    //               'password'=>Hash::make($password)
    //               ]);
            
    //           Session::flash('message', "Account Successfully Created");
    //           return Redirect::back();
    //       }
        return Redirect::back()->withInput()->withErrors($validation);      
    }
}
   