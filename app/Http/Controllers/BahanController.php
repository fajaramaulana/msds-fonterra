<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Listjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bahan::join('listjasas', 'bahans.id_jasa', '=', 'listjasas.id')
                ->select('listjasas.name as jasa', 'bahans.id', 'bahans.nama_bahan', 'bahans.image', 'bahans.created_at', 'bahans.status');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->nama_bahan . '\')">Edit</button>';

                    return $btn;
                })
                ->addColumn('gambar', function ($row) {
                    if ($row->image != null) {
                        $url = env('PATH_IMAGE') . $row->image;
                        return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                    } else {
                        return 'Deleted';
                    }
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? "Active" : "Non active";
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('admin.bahan.index');
    }


    public function create()
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        return view('admin.bahan.create', [
            "jasas" => $jasa,
        ]);
    }

    public function store(Request $request)
    {
        $rules = array(
            'nama_bahan' => 'required',
            'gambar' => 'mimes:jpeg,jpg,png|required|max:10000|dimensions:max_width=370,max_height=359,min_width=370,min_height=359',
            'description' => 'required|max:140'
        );

        $messages = array(
            'nama_bahan.required' => 'Nama Pola is required.',
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
            $gambar = $request->file('gambar');
            $extension = $request->file('gambar')->guessExtension();
            $newGambarName = slugify($request->nama_bahan) . "-" . randString(4) . "." . $extension;
            $pathImage = base_path('..\mainData\bahan\\') . $newGambarName;
            try {
                $gambar->move(base_path('..\mainData\bahan'), $newGambarName);
                try {
                    Bahan::create([
                        'id_jasa' => $request->id_jasa,
                        'nama_bahan'  => $request->nama_bahan,
                        'description' => $request->description,
                        'image' => 'bahan/' . $newGambarName,
                        'status' => $request->status,
                    ]);
                } catch (\Throwable $th) {
                    unlink($pathImage);
                    return [
                        'success' => 2,
                        'message' => "Error on store data to database. \n" . $th->getMessage()
                    ];
                }
            } catch (\Throwable $th) {
                return [
                    'success' => 2,
                    'message' => "Error on store image to storage. \n" . $th->getMessage()
                ];
            }

            return [
                'success' => 1,
                'message' => "Success Insert Bahan"
            ];
        }
    }

    public function removeImageBahan(Request $request)
    {
        $idBahan = $request->id;
        $bahan = Bahan::where('id', $idBahan)->select('image')->get();
        $bahanUpdate = Bahan::findOrFail($idBahan);
        $pathImage = base_path('..\mainData\\') . $bahan[0]['image'];

        try {
            @unlink($pathImage);
            try {
                $bahanUpdate->update([
                    'image' => null,
                    "status" => 0
                ]);
                return [
                    'success' => 1,
                    'message' => "Success Remove Image"
                ];
            } catch (\Throwable $th) {
                return [
                    'success' => 0,
                    'message' => "Error On Deleting Data On Database. " . $th->getMessage()
                ];
            }
        } catch (\Throwable $th) {
            return [
                'success' => 0,
                'message' => "Error On Deleting File On Storage! " . $th->getMessage()
            ];
        }
    }


    public function edit($id)
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        $bahan = Bahan::select('id', 'id_jasa', 'nama_bahan', 'description', 'image', 'status')->findorfail($id);
        return view('admin.bahan.edit', [
            "jasas" => $jasa,
            "bahans" => $bahan
        ]);
    }


    public function update(Request $request, Bahan $bahan)
    {
        $rules = array(
            'nama_bahan' => 'required|min:5',
            'description' => 'required|max: 140'
        );

        if ($request->gambar != null) {
            $rules['gambar']  = 'mimes:jpeg,jpg,png|required|max:10000|dimensions:max_width=370,max_height=359,min_width=370,min_height=359';
        }

        $messages = array(
            'nama_bahan.required' => 'Nama Bahan is required.',
            'nama_bahan.min' => 'Nama Bahan min 5 character.',
            'nama_bahan.max' => 'Nama Bahan max 20 character.',
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

            $bahanUp = Bahan::findorfail($bahan->id);

            if ($request->has('gambar')) {
                $gambar = $request->file('gambar');
                $extension = $request->file('gambar')->guessExtension();
                $newGambarName = slugify($request->nama_bahan) . "-" . randString(4) . "." . $extension;
                try {
                    $gambar->move(base_path('..\mainData\bahan'), $newGambarName);
                } catch (\Throwable $th) {
                    return [
                        'success' => 2,
                        'message' => "Error on store image to Storage. \n" . $th->getMessage()
                    ];
                }

                $bahan_data = [
                    'nama_bahan'  => $request->nama_bahan,
                    'description'  => $request->description,
                    'id_jasa' => $request->id_jasa,
                    'image' => 'bahan/' . $newGambarName,
                    'status' => $request->status,
                ];
            } else {
                if ($request->gambar == null && $request->status == 1 && $bahanUp['image'] == "" ) {
                    return [
                        'success' => 2,
                        'message' => "You Need To Upload Image First before you Activate this Jasa."
                    ];
                } else {
                    $bahan_data = [
                        'nama_bahan'  => $request->nama_bahan,
                        'description'  => $request->description,
                        'id_jasa' => $request->id_jasa,
                        'status' => $request->status,
                    ];
                }
            }

            try {
                $bahanUp->update($bahan_data);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => 2,
                    'message' => "Error on store data to database. \n\n" . $th->getMessage()
                ]);
            }

            return [
                'success' => 1,
                'message' => "Success Update Portofolio"
            ];
        }
    }


    public function destroy($id)
    {
    }
}
