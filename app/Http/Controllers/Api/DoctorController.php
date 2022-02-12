<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('id', 'desc')->get();
        $user_id = Auth()->user();

        return response()->json([
            'user' => $user_id,
            'doctors' => $doctors,
        ]);
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
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            //            'email' => [
            //                'required',
            //                Rule::unique('users')->ignore($user->id),
            //            ],
            'password' => 'required|string',
            'phone' => 'required|string',
            'dob' => 'required|string',
            'gender' => 'required|string',
            'nid_passport' => 'required',
            'bmdc_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'validator' => $validator->errors()
            ]);
        } else {

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


            if ($request->hasFile('avatar')) {
                $inputImage = $request->file('avatar');
                $imageName = time() . '.' . $inputImage->extension();
                // Delete Image
                File::delete('uploads/' . $doctor->avatar);
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


            // Assign user id to doctor table 


            return response()->json([
                'success' => true,
                'message' => 'doctor registration was successful'
            ]);
        }
    }



    public function edit($id)
    {
        // Retrieving models
        $doctor = Doctor::find($id);

        if ($doctor) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'doctor' => $doctor
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'No doctor found'
            ]);
        }
    }
}
