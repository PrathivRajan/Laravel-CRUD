<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;

class MyController extends Controller
{
    public function UserCodeRandomNumber()
    {
        $usercode = rand(0000000,999999);
        //return view('registration', ['usercode'=>$usercode]); //return view('carBrand', ['carsBrandList' => $arrayCars, 'brandOwners' => $arrayOwners]);
        return view('registration', compact('usercode'));
    }

    public function Registration(Request $request)
    {

        $datavalidation = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'usercode' => 'required|integer|unique:users',
            'username'=> 'required|string',
            'email' => 'required|email|unique:users',
            'department' => 'required|string',
            'password' => 'required|string|min:3|max:8|required_with:password_repeat|same:password_repeat',
            'password_repeat' => 'required|string|min:3|max:8',
        ]);

        DB::beginTransaction();
        try
        {
            $userdata = new User;
            if($request->hasFile('image')){
                $image  = $request->file('image');
                $filename = $image->getClientOriginalName();
                $image->move('uploads', $filename);
            }
            $userdata->image = $filename;
            $userdata->usercode = $request->usercode;
            $userdata->name = $request->username;
            $userdata->email = $request->email;
            $userdata->department = $request->department;
            $userdata->password = Hash::make($request->password);
            $userdata->save();

            DB::commit();
            return redirect()->back()->with('status', 'Registred Successfully');
        }
        catch ( Exception $error )
        {
            DB::rollback();
            return redirect()->back()->with('status', 'Registration Failed');
        }
    }

}
