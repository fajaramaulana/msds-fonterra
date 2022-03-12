<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::select('id', 'judul', 'gambar', 'created_at', 'status');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->judul . '\')">Edit</button>';

                    return $btn;
                })
                ->addColumn('gambar', function ($row) {
                    if ($row->gambar != null) {
                        $url = env('PATH_IMAGE') . $row->gambar;
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
        return view('admin.banner.index');
    }


    public function create()
    {
        return view('admin.banner.create');
    }

    public function edit($id)
    {
        $banner = Banner::select('id', 'judul', 'rangkuman', 'gambar', 'status')->findorfail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'judul' => 'required|min:5',
            'rangkuman' => 'required|min:5',
            'gambar' => 'mimes:jpeg,jpg,png|required|max:10000'
        );

        $messages = array(
            'judul.required' => 'Title is required.',
            'judul.min' => 'Title min 5 character.',
            'judul.max' => 'Title max 20 character.',
            'rangkuman.required' => 'Description is required.',
            'rangkuman.min' => 'Description min 5 character.',
            'rangkuman.max' => 'Description max 20 character.',
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
            $newGambarName = slugify($request->judul) . "-" . randString(4) . "." . $extension;
            $gambar->move(base_path('..\mainData\banner'), $newGambarName);
            Banner::create([
                'judul' => $request->judul,
                'rangkuman' => $request->rangkuman,
                'gambar' => 'banner/' . $newGambarName,
                'status' => 1
            ]);


            return [
                'success' => 1,
                'message' => "Success Create Banner"
            ];
        }
    }


    public function removeImageBanner(Request $request)
    {
        $idBanner = $request->id;
        $banner = Banner::where('id', $idBanner)->select('gambar')->get();
        $bannerUpdate = Banner::findOrFail($idBanner);
        $pathImage = base_path('..\mainData\\') . $banner[0]['gambar'];

        try {
            unlink($pathImage);
            try {
                $bannerUpdate->update([
                    'gambar' => null,
                    "status" => 0
                ]);
                return [
                    'success' => 1,
                    'message' => "Success Remove Image"
                ];
            } catch (\Throwable $th) {
                return [
                    'success' => 0,
                    'message' => "Error On Deleting Data On Database"
                ];
            }
        } catch (\Throwable $th) {
            return [
                'success' => 0,
                'message' => "Error On Deleting File On Storage!"
            ];
        }
    }


    public function update(Request $request, $id)
    {
        $rules = array(
            'judul' => 'required|min:5',
            'rangkuman' => 'required|min:5',
            'status' => 'required'
        );

        if ($request->gambar != null) {
            $rules['gambar']  = 'mimes:jpeg,jpg,png|required|max:10000';
        }

        $messages = array(
            'judul.required' => 'Title is required.',
            'judul.min' => 'Title min 5 character.',
            'judul.max' => 'Title max 20 character.',
            'rangkuman.required' => 'Description is required.',
            'rangkuman.min' => 'Description min 5 character.',
            'rangkuman.max' => 'Description max 20 character.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            $banner = Banner::findorfail($id);
            if ($request->has('gambar')) {
                $gambar = $request->file('gambar');
                $extension = $request->file('gambar')->guessExtension();
                $newGambarName = slugify($request->judul) . "-" . randString(4) . "." . $extension;
                try {
                    $gambar->move(base_path('..\mainData\banner'), $newGambarName);
                } catch (\Throwable $th) {
                    return [
                        'success' => 2,
                        'message' => "Error on store image to Storage. \n" . $th->getMessage()
                    ];
                }

                $banner_data = [
                    'judul' => $request->judul,
                    'rangkuman' => $request->rangkuman,
                    'status' => $request->status,
                    'gambar' => "banner/".$newGambarName
                ];
            } else {
                $banner_data = [
                    'judul' => $request->judul,
                    'rangkuman' => $request->rangkuman,
                    'status' => $request->status,
                ];
            }

            try {
                $banner->update($banner_data);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => 2,
                    'message' => "Error. \n" .$th->getMessage()
                ]);
                die();
            }

            return [
                'success' => 1,
                'message' => "Success Update Banner"
            ];
        }
    }


    public function destroy($id)
    {
        $banner = banner::find($id);
        $banner->delete();

        return redirect()->back()->with('success', 'Banner Berhasil Dihapus');
    }
}
