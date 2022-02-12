<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('id','desc')->get();
        return view('backend.doctor.index', compact('doctors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.doctor.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'phone' => 'required|string',
            'dob' => 'required|string',
            'gender' => 'required|string',
            'nid_passport' => 'required',
            'bmdc_number' => 'required|string',
        ]);

        $doctor = new Doctor();
        $doctor->title = $request->input('title');
        $doctor->name = $request->input('name');
        $doctor->email = $request->input('email');
        $doctor->phone = $request->input('phone');
        $doctor->dob = $request->input('dob');
        $doctor->nid_passport = $request->input('nid_passport');
        $doctor->gender = $request->input('gender');
        $doctor->consultation_fee = $request->input('consultation_fee');
        $doctor->total_experience = $request->input('total_experience');
        $doctor->bmdc_number = $request->input('bmdc_number');
        $doctor->working_in = $request->input('working_in');
        $doctor->qualification = $request->input('qualification');
        $doctor->availability = $request->input('availability');
        $doctor->consultation_time = $request->input('consultation_time');
        $doctor->about_doctor = $request->input('about_doctor');
        $doctor->status = $request->input('status');


        if($request->hasFile('avatar')) {
            $inputImage = $request->file('avatar');
            $imageName = time() . '.' . $inputImage->extension();
            // Delete Image
            File::delete('uploads/'.$doctor->avatar);
            $inputImage->move(public_path('uploads'), $imageName);
            $doctor->avatar = $imageName;
        }

        $doctor->save();

        // Create user account
        $user = new User();
        $user->doctor_id = $doctor->id;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->dob = $request->input('dob');

        $user->save();


        return redirect()->back()->with(['msg' => 'Doctor Added Successfully', 'type' => 'success']);

    }


}
