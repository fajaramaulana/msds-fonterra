<?php
/**
 * @project     MSDS Fontera
 * @author      Fajar Agus Maulana
 * @copyright   Copyright (c) 2022, https://github.com/fajaramaulana/
 * @link 		https://github.com/fajaramaulana/
*/
namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DepartementController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Departement::select('id','name', 'email');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->name . '\')">Edit</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.departement.index');
    }

    public function create()
    {
        return view('admin.departement.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required|min:3',
            'email' => 'required|regex:/^.+@.+$/i',
        );

        $messages = array(
            'name.required' => 'Nama Departement is required.',
            'name.min' => 'Nama Departement min 3 character.',
            'email.required' => 'Email is required.',
            'email.regex' => 'Bukan Format Email.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            try {
                Departement::create([
                    'name' => $request->name,
                    'email'  => $request->email
                ]);
            } catch (\Throwable $th) {
                return [
                    'success' => 2,
                    'message' => "Error on store data to database. \n" . $th->getMessage()
                ];
            }

            return [
                'success' => 1,
                'message' => "Success Create Departement"
            ];
        }
    }


    public function edit($id)
    {
        $departement = Departement::select('id', 'name', 'email')->findorfail($id);
        return view('admin.departement.edit', [
            "departement" => $departement
        ]);
    }


    public function update(Request $request, $id)
    {
        $rules = array(
            'name' => 'required|min:3',
            'email' => 'required|regex:/^.+@.+$/i',
        );

        $messages = array(
            'name.required' => 'Nama Departement is required.',
            'name.min' => 'Nama Departement min 3 character.',
            'email.required' => 'Email is required.',
            'email.regex' => 'Bukan Format Email.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            $testimoni = Departement::findorfail($id);
            $testimoni_data = [
                'name'  => $request->name,
                'email'  => $request->email,
            ];

            try {
                $testimoni->update($testimoni_data);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => 2,
                    'message' => "Error on store data to database. \n\n" . $th->getMessage()
                ]);
            }

            return [
                'success' => 1,
                'message' => "Success Update Departement"
            ];
        }
    }

    public function destroy($id)
    {
       
    }
}