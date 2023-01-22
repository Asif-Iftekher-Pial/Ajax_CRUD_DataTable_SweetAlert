<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function allData(){
        return view('allData');
    }

    
    public function data()
    {
        $data = User::latest();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="' . $data->id . '" data-bs-toggle="modal"
                data-bs-target="#editModal" class="btn editButton btn-sm btn-warning">Edit</a> |
                <a  data-id="' . $data->id . '" class="btn deleteButton btn-sm btn-danger">Delete</a>';
            })->make(true);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first' => 'string|required',
            'last' => 'string|required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('Ymdhms') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/'), $filename);
            }
            $user = new User();
            $user->first = $request->first;
            $user->last = $request->last;
            $user->image = $filename;
            $status = $user->save();
            if ($status) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Saved successfully!',
                ]);
            }
        }
    }

    public function edit($id){
        $data = User::FindorFail($id);
        return response()->json($data);
    }

    public function update(Request $request,$id){
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'first' => 'string|required',
            'last' => 'string|required',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {


            $data = User::FindOrFail($id);

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('Ymdhms') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/'), $filename);
                @unlink(public_path('images/' . $data->image));
            }
            
            $data->first = $request->first;
            $data->last = $request->last;
            $data->image = $filename;
            $status = $data->save();
            if ($status) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated successfully!',
                ]);
            }
        }

    }

    public function delete($id)
    {
        // dd($id);
        $data = User::FindorFail($id);
        @unlink(public_path('images/' . $data->image));
        $data->delete();
        return response()->json(['status' => 200]);
    }
}
