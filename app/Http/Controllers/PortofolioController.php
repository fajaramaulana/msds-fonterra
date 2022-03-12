<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\Listjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PortofolioController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Portofolio::join('listjasas', 'portofolios.id_jasa', '=', 'listjasas.id')
                ->select('listjasas.name as jasa', 'portofolios.id', 'portofolios.name', 'portofolios.image', 'portofolios.created_at', 'portofolios.status');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->name . '\')">Edit</button>';

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
        return view('admin.portofoliomanagement.index');
    }


    public function create()
    {
        $jasa = Listjasa::select('id', 'name')->where("status", 1)->orderBy('name', 'desc')->get();
        return view('admin.portofoliomanagement.create', [
            "jasas" => $jasa,
        ]);
    }


    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required|min:5',
            'gambar' => 'mimes:jpeg,jpg,png|required|max:10000',
        );

        $messages = array(
            'name.required' => 'Nama is required.',
            'name.min' => 'Nama min 5 character.',
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

            if ($orientation != "landscape") {
                return [
                    'success' => 2,
                    'message' => "Gambar Harus Landscape, gambar yang anda kirimkan " . $orientation . "."
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
            $newGambarName = slugify($request->name) . "-" . randString(4) . "." . $extension;
            $pathImage = base_path('..\mainData\portofolio\\') . $newGambarName;
            try {
                $gambar->move(base_path('..\mainData\portofolio'), $newGambarName);
                try {
                    Portofolio::create([
                        'id_jasa' => $request->id_jasa,
                        'name'  => $request->name,
                        'image' => 'portofolio/' . $newGambarName,
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
                'message' => "Success Create Portofolio"
            ];
        }
    }

    public function show($id)
    {
    }

    public function removeImagePortofolio(Request $request)
    {
        $idPortofolio = $request->id;
        $portofolio = Portofolio::where('id', $idPortofolio)->select('image')->get();
        $portofolioUpdate = Portofolio::findOrFail($idPortofolio);
        $pathImage = base_path('..\mainData\\') . $portofolio[0]['image'];

        try {
            @unlink($pathImage);
            try {
                $portofolioUpdate->update([
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
        $portofolio = Portofolio::select('id', 'id_jasa', 'name', 'image', 'status')->findorfail($id);
        return view('admin.portofoliomanagement.edit', [
            "jasas" => $jasa,
            "porto" => $portofolio
        ]);
    }


    public function update(Request $request, Portofolio $portofolio)
    {
        $rules = array(
            'name' => 'required|min:5',
        );

        if ($request->gambar != null) {
            $rules['gambar']  = 'mimes:jpeg,jpg,png|required|max:10000';
        }

        $messages = array(
            'name.required' => 'Name is required.',
            'name.min' => 'Name min 5 character.',
            'name.max' => 'Name max 20 character.',
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

            if ($orientation != "landscape") {
                return [
                    'success' => 2,
                    'message' => "Gambar Harus Landscape, gambar yang anda kirimkan " . $orientation . "."
                ];
            }

            if ($request->id_jasa == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Jasa Terlebih dahulu."
                ];
            }

            $portofolio = Portofolio::findorfail($portofolio->id);

            if ($request->has('gambar')) {
                $gambar = $request->file('gambar');
                $extension = $request->file('gambar')->guessExtension();
                $newGambarName = slugify($request->name) . "-" . randString(4) . "." . $extension;
                try {
                    $gambar->move(base_path('..\mainData\portofolio'), $newGambarName);
                } catch (\Throwable $th) {
                    return [
                        'success' => 2,
                        'message' => "Error on store image to Storage. \n" . $th->getMessage()
                    ];
                }

                $portofolio_data = [
                    'name'  => $request->name,
                    'id_jasa' => $request->id_jasa,
                    'image' => 'portofolio/' . $newGambarName,
                    'status' => $request->status,
                ];
            } else {
                if ($request->gambar == null & $request->status == 1) {
                    return [
                        'success' => 2,
                        'message' => "You Need To Upload Image First before you Activate this Jasa."
                    ];
                } else {
                    $portofolio_data = [
                        'name'  => $request->name,
                        'id_jasa' => $request->id_jasa,
                        'status' => $request->status,
                    ];
                }
            }

            try {
                $portofolio->update($portofolio_data);
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
