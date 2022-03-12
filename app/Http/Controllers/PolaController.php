<?php

namespace App\Http\Controllers;

use App\Models\Pola;
use App\Models\Listjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PolaController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pola::join('listjasas', 'polas.id_jasa', '=', 'listjasas.id')
                ->select('listjasas.name as jasa', 'polas.id', 'polas.nama_pola', 'polas.image', 'polas.created_at', 'polas.status');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->nama_pola . '\')">Edit</button>';

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
        return view('admin.pola.index');
    }

    
    public function create()
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        return view('admin.pola.create', [
            "jasas" => $jasa,
        ]);
    }

    
    public function store(Request $request)
    {
        $rules = array(
            'nama_pola' => 'required',
            'gambar' => 'mimes:jpeg,jpg,png|required|max:10000',
        );

        $messages = array(
            'name_pola.required' => 'Nama Pola is required.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            list($width, $height) = getimagesize($request->file('gambar'));
            if ($width > $height) {
                $orientation = "landscape";
            } else if ($width == $height) {
                $orientation = "box";
            } else {
                $orientation = "portrait";
            }

            if ($orientation != "portrait") {
                return [
                    'success' => 2,
                    'message' => "Gambar Harus Potrait, gambar yang anda kirimkan " . $orientation . "."
                ];
            }

            if ($request->id_jasa == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Jasa Terlebih dahulu."
                ];
            }
            $gambar = $request->file('gambar');
            $extension = $request->file('gambar')->guessExtension();
            $newGambarName = slugify($request->nama_pola) . "-" . randString(4) . "." . $extension;
            $pathImage = base_path('..\mainData\pola\\') . $newGambarName;
            try {
                $gambar->move(base_path('..\mainData\pola'), $newGambarName);
                try {
                    Pola::create([
                        'id_jasa' => $request->id_jasa,
                        'nama_pola'  => $request->nama_pola,
                        'image' => 'pola/' . $newGambarName,
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
                'message' => "Success Insert Pola"
            ];
        }
    }

    
    public function removeImagePortofolio(Request $request)
    {
        $idPola = $request->id;
        $pola = Pola::where('id', $idPola)->select('image')->get();
        $polaUpdate = Pola::findOrFail($idPola);
        $pathImage = base_path('..\mainData\\') . $pola[0]['image'];

        try {
            @unlink($pathImage);
            try {
                $polaUpdate->update([
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
        $pola = Pola::select('id', 'id_jasa', 'nama_pola', 'image', 'status')->findorfail($id);
        return view('admin.pola.edit', [
            "jasas" => $jasa,
            "pola" => $pola
        ]);
    }

    
    public function update(Request $request, Pola $pola)
    {
        $rules = array(
            'nama_pola' => 'required',
        );

        if ($request->gambar != null) {
            $rules['gambar']  = 'mimes:jpeg,jpg,png|required|max:10000';
        }

        $messages = array(
            'nama_pola.required' => 'Name Pola is required.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            list($width, $height) = getimagesize($request->file('gambar'));
            if ($width > $height) {
                $orientation = "landscape";
            } else if ($width == $height) {
                $orientation = "box";
            } else {
                $orientation = "portrait";
            }

            if ($orientation != "portrait") {
                return [
                    'success' => 2,
                    'message' => "Gambar Harus Potrait, gambar yang anda kirimkan " . $orientation . "."
                ];
            }

            if ($request->id_jasa == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Jasa Terlebih dahulu."
                ];
            }

            $polaUp = Pola::findorfail($pola->id);

            if ($request->has('gambar')) {
                $gambar = $request->file('gambar');
                $extension = $request->file('gambar')->guessExtension();
                $newGambarName = slugify($request->nama_pola) . "-" . randString(4) . "." . $extension;
                try {
                    $gambar->move(base_path('..\mainData\pola'), $newGambarName);
                } catch (\Throwable $th) {
                    return [
                        'success' => 2,
                        'message' => "Error on store image to Storage. \n" . $th->getMessage()
                    ];
                }

                $pola_data = [
                    'nama_pola'  => $request->nama_pola,
                    'id_jasa' => $request->id_jasa,
                    'image' => 'pola/' . $newGambarName,
                    'status' => $request->status,
                ];
            } else {
                if ($request->gambar == null & $request->status == 1) {
                    return [
                        'success' => 2,
                        'message' => "You Need To Upload Image First before you Activate this Jasa."
                    ];
                } else {
                    $pola_data = [
                        'nama_pola'  => $request->nama_pola,
                        'id_jasa' => $request->id_jasa,
                        'status' => $request->status,
                    ];
                }
            }

            try {
                $polaUp->update($pola_data);
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
