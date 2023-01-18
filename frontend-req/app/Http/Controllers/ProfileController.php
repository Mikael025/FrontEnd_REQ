<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Controllers\CloudinaryStorage;

class ProfileController extends Controller
{

    public function index()
    {
        $all = Profile::all();
        return response()->json(["data"=>$all],200);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:14',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'photo' => 'mimes:jpg,png,jpeg'
        ]);

        if (isset($request->photo))
        {
            $image  = $request->file('photo');
            $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
            Profile::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'photo' => $result
                    ]
            );
            return response()->json(["status"=> "Data Created"],200);
        }
    }

    public function show($id)
    {
        $data = Profile::where('id',$id)->get();
        return response()->json(["data" => $data],200);
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:14',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'photo' => 'mimes:jpg,png,jpeg'
        ]);

        $single = Profile::where('id',$id)->get();

        // return response()->json(["data"=>$single],200);

        if (isset($request->photo))
        {

            $file   = $request->file('photo');
            $result = CloudinaryStorage::replace($single[0]->photo, $file->getRealPath(), $file->getClientOriginalName());
            $single[0]->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'photo' => $result
                    ]
            );
            return response()->json(["status"=> "Data Updated"],200);
        }

    }


    public function delete($id)
    {
        $data = Profile::find($id);
        $photo = $data->photo;
        // return response()->json(["status" => $photo],200);

        CloudinaryStorage::delete($photo);
        $data->delete();
        return response()->json(["status" => "data sudah dihapus"],200);
    }
}
