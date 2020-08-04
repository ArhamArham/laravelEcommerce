<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreUserProfile;
use App\User;
use App\Profile;
use App\Role;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $roles=Role::all();
        $countries=Country::all();
        return view('admin.users.create',compact('roles','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
        //
        //dd($request->all());
        $path='images/no-thumbnail.jpeg';
        $validated = $request->validated();
        $extension=".".$request->thumbnail->getClientOriginalExtension();
        $name=basename($request->thumbnail->getClientOriginalName(),$extension).time();
        $name=$name.$extension;
        $path=$request->thumbnail->storeAs('images/profile',$name,'public');
        $user=User::create([
            'email'=>$request->email,
            'password'=>bcrypt($request->password) ,
            'status'=>$request->status,
        ]);
        if($user)
        {
            $profile=Profile::create([
                'user_id'=>$user->id,
                'name'=>$request->name,
                'address'=>$request->address,
                'country_id'=>$request->country_id,
                'state_id'=>$request->state_id,
                'city_id'=>$request->city_id,
                'phone'=>$request->phone,
                'slug'=>$request->slug,
                'thumbnail'=>$path,
            ]);
        }
        if($validated && $user && $profile)
        {
            return redirect(route('admin.profile.index'))->with('message','User Successfully Added');
        }
        else
        {
            return back()->with('message','Error plz try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        
        $user = User::where('id',$profile->user_id)->first();
        $countries = Country::all();
        //$s=State::where('country_id',$countries->id)->get;
        //dd($countries->array());
        $roles = Role::all();
		return view('admin.users.create', compact('user', 'roles', 'countries'));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
        //dd($request->all());
        if($request->has('thumbnail')){
        $extension=".".$request->thumbnail->getClientOriginalExtension();
        $name=basename($request->thumbnail->getClientOriginalName(),$extension).time();
        $name=$name.$extension;
        $path=$request->thumbnail->storeAs('images/profile',$name,'public');
        $profile->thumbnail=$path;
        }
        $user=User::where('id','=',$profile->user_id)->first();
        $profile->name=$request->name;
        $profile->address=$request->address;
        $profile->phone=$request->phone;
        $profile->slug=$request->slug;
        $profile->country_id=$request->country_id;
        $profile->state_id=$request->state_id;
        $profile->city_id=$request->city_id;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->previous_password ==! Null) {
            if(Hash::check($request->previous_password, $user->password)) {
                if ($request->new_password == !Null) {
                    # code...
                    $user->password=bcrypt($request->new_password);
                    
                }
                else
                {
                    return back()->with('message','Plz enter a new password');
                }
            }
            else
            {
                return back()->with('message','Previous Password does not match plz enter again');
            }    
        }
        if($profile->save() && $user->save())
        {
            return redirect(route('admin.profile.index'))->with('message','User details successfully changed');
        }
        else{
            return redirect(route('admin.profile.index'))->with('message','There is a problem plz try again');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
        if ($udelete=User::where('id',$profile->user_id)->forceDelete()) {
            if($udelete && $profile->forceDelete()) 
            {
                Storage::delete('public/'.$profile->thumbnail);   
                return back()->with('message','Profile Successfully Deleted');    
            }
            
        } 
        else
        {
            # code...
            return back()->with('message','Profile not deleted');
        }
    }
    public function trash()
    {
        $users=User::onlyTrashed()->get();
        return view('admin.users.index',['users'=>$users,'checktrash'=>'Yes']);
    }
    public function recover($id)
    {
        $user=User::withTrashed()->findOrFail($id);
        if ($user->restore()) {
            # code...
            return back()->with('message','Product Successfully recoverd');
        } else {
            # code...
            return back()->with('message','Product not recovered');
        }
    }
    public function remove(User $id)
    {
        if ($id->delete()) {
            # code...
            return back()->with('message','Profile Successfully Trash');
        } else {
            # code...
            return back()->with('message','Profile not trash');
        }
    }
    public function getStates(Request $request, $id)
    {
        if($request->ajax()){
            return State::where('country_id',$id)->get();
        }
        else
        {
        return 0;
        }
    }
    public function getCities(Request $request, $id)
    {
        if($request->ajax())
        return City::where('state_id',$id)->get();
        else
        return 0;
    }
}
