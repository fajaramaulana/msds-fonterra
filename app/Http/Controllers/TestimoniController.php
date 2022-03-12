<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use App\Models\Listjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TestimoniController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimoni::join('listjasas', 'testimonis.id_jasa', '=', 'listjasas.id')
                ->select('listjasas.name as jasa', 'testimonis.id', 'testimonis.nama_pemesan', 'testimonis.created_at', 'testimonis.status');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->nama_pemesan . '\')">Edit</button>';

                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? "Active" : "Non active";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.testimoni.index');
    }


    public function create()
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        return view('admin.testimoni.create', [
            "jasas" => $jasa,
        ]);
    }


    public function store(Request $request)
    {
        $rules = array(
            'nama_pemesan' => 'required|min:5',
            'message' => 'required|min:10',
        );

        $messages = array(
            'nama_pemesan.required' => 'Nama is required.',
            'nama_pemesan.min' => 'Nama min 5 character.',
            'message.required' => 'Pesan is required.',
            'message.min' => 'Pesan min 10 character.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {

            if ($request->id_jasa == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Jasa Terlebih dahulu."
                ];
            }
            try {
                Testimoni::create([
                    'id_jasa' => $request->id_jasa,
                    'nama_pemesan'  => $request->nama_pemesan,
                    'message' => $request->message,
                    'status' => $request->status,
                ]);
            } catch (\Throwable $th) {
                return [
                    'success' => 2,
                    'message' => "Error on store data to database. \n" . $th->getMessage()
                ];
            }

            return [
                'success' => 1,
                'message' => "Success Create Testimoni"
            ];
        }
    }



    public function edit($id)
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        $testimoni = Testimoni::select('id', 'id_jasa', 'nama_pemesan', 'message','status')->findorfail($id);
        return view('admin.testimoni.edit', [
            "jasas" => $jasa,
            "testi" => $testimoni
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = array(
            'nama_pemesan' => 'required|min:5',
            'message' => 'required|min:10',
        );

        $messages = array(
            'nama_pemesan.required' => 'Nama Pemesan is required.',
            'nama_pemesan.min' => 'Nama Pemesan min 5 character.',
            'nama_pemesan.max' => 'Nama Pemesan max 20 character.',
            'message.required' => 'Pesan is required.',
            'message.min' => 'Pesan min 5 character.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            if ($request->id_jasa == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Jasa Terlebih dahulu."
                ];
            }

            $testimoni = Testimoni::findorfail($id);
            $testimoni_data = [
                'nama_pemesan'  => $request->nama_pemesan,
                'id_jasa'  => $request->id_jasa,
                'message' => $request->message,
                'status' => $request->status,
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
                'message' => "Success Update Testimoni"
            ];
        }
    }


    public function destroy($id)
    {
        //
    }
}
