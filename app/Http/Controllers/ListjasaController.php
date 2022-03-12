<?php

namespace App\Http\Controllers;

use App\Models\Listjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ListjasaController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Listjasa::select('id', 'name', 'image', 'created_at', 'status');
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
        return view('admin.listjasa.index');
    }

    public function create()
    {
        return view('admin.listjasa.create');
    }

    public function edit($id)
    {
        $listjasa = Listjasa::select('id', 'name', 'description', 'image', 'status', 'meta_title', 'meta_description', 'meta_keywords')->findorfail($id);
        return view('admin.listjasa.edit', compact('listjasa'));
    }

    public function removeImageListJasa(Request $request)
    {
        $idJasa = $request->id;
        $jasa = Listjasa::where('id', $idJasa)->select('image')->get();
        $jasaUpdate = Listjasa::findOrFail($idJasa);
        $pathImage = base_path('..\mainData\\') . $jasa[0]['image'];

        try {
            @unlink($pathImage);
            try {
                $jasaUpdate->update([
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

    public function store(Request $request)
    {
        $rules = array(
            'namajasa' => 'required|min:5',
            'deskripsi' => 'required|min:5',
            'gambar' => 'mimes:jpeg,jpg,png|required|max:10000|dimensions:max_width=370,max_height=215,min_width=370,min_height=215',
            'metatitle' => 'required',
            'metadescription' => 'required',
            'metakeyword' => 'required',
        );

        $messages = array(
            'namajasa.required' => 'Nama Jasa is required.',
            'namajasa.min' => 'Nama Jasa min 5 character.',
            'namajasa.max' => 'Nama Jasa max 20 character.',
            'deskripsi.required' => 'Deskripsi is required.',
            'deskripsi.min' => 'Deskripsi min 5 character.',
            'deskripsi.max' => 'Deskripsi max 20 character.',
            'metatitle.required' => 'Meta Title is required.',
            'metadescription.required' => 'Meta Description is required.',
            'metakeyword.required' => 'Meta Keyword is required.',
            'gambar.dimensions' => 'Dimensi gambar harus 370x214'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            $gambar = $request->file('gambar');
            $extension = $request->file('gambar')->guessExtension();
            $newGambarName = slugify($request->namajasa) . "-" . randString(4) . "." . $extension;
            $pathImage = base_path('..\mainData\jasa\\') . $newGambarName;
            try {
                $gambar->move(base_path('..\mainData\jasa'), $newGambarName);
                try {
                    Listjasa::create([
                        'name'  => $request->namajasa,
                        'slug'  => slugify($request->namajasa),
                        'description' => $request->deskripsi,
                        'image' => 'jasa/' . $newGambarName,
                        'status' => 1,
                        'meta_title' => $request->metatitle,
                        'meta_description' => $request->metadescription,
                        'meta_keywords' =>  $request->metakeyword,
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
                'message' => "Success Create List Jasa"
            ];
        }
    }

    public function update(Request $request, Listjasa $listjasa)
    {
        $rules = array(
            'namajasa' => 'required|min:5',
            'deskripsi' => 'required|min:5',
            'metatitle' => 'required',
            'metadescription' => 'required',
            'metakeyword' => 'required',
        );

        if ($request->gambar != null) {
            $rules['gambar']  = 'mimes:jpeg,jpg,png|required|max:10000|dimensions:max_width=370,max_height=215,min_width=370,min_height=215';
        }

        $messages = array(
            'namajasa.required' => 'Nama Jasa is required.',
            'namajasa.min' => 'Nama Jasa min 5 character.',
            'namajasa.max' => 'Nama Jasa max 20 character.',
            'deskripsi.required' => 'Deskripsi is required.',
            'deskripsi.min' => 'Deskripsi min 5 character.',
            'deskripsi.max' => 'Deskripsi max 20 character.',
            'metatitle.required' => 'Meta Title is required.',
            'metadescription.required' => 'Meta Description is required.',
            'metakeyword.required' => 'Meta Keyword is required.',
            'gambar.dimensions' => 'Dimensi gambar harus 370x214'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            $listJasa = Listjasa::findorfail($listjasa->id);
            if ($request->has('gambar')) {
                $gambar = $request->file('gambar');
                $extension = $request->file('gambar')->guessExtension();
                $newGambarName = slugify($request->namajasa) . "-" . randString(4) . "." . $extension;
                try {
                    $gambar->move(base_path('..\mainData\jasa'), $newGambarName);
                } catch (\Throwable $th) {
                    return [
                        'success' => 2,
                        'message' => "Error on store image to Storage. \n" . $th->getMessage()
                    ];
                }

                $banner_data = [
                    'name'  => $request->namajasa,
                    'slug'  => slugify($request->namajasa),
                    'description' => $request->deskripsi,
                    'image' => 'jasa/' . $newGambarName,
                    'status' => 1,
                    'meta_title' => $request->metatitle,
                    'meta_description' => $request->metadescription,
                    'meta_keywords' =>  $request->metakeyword,
                ];
            } else {
                if($request->gambar == null & $request->status == 1){
                    return [
                        'success' => 2,
                        'message' => "You Need To Upload Image First before you Activate this Jasa."
                    ];
                }else{
                    $banner_data = [
                        'name'  => $request->namajasa,
                        'slug'  => slugify($request->namajasa),
                        'description' => $request->deskripsi,
                        'status' => $request->status,
                        'meta_title' => $request->metatitle,
                        'meta_description' => $request->metadescription,
                        'meta_keywords' =>  $request->metakeyword,
                    ];
                }
                
            }

            try {
                $listJasa->update($banner_data);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => 2,
                    'message' => "Error on store data to database. \n\n" . $th->getMessage()
                ]);
            }

            return [
                'success' => 1,
                'message' => "Success Update List Jasa"
            ];
        }
    }


    public function destroy(Listjasa $listjasa)
    {
        //
    }
}
