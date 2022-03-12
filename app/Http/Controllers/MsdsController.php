<?php

/**
 * @project     MSDS Fontera
 * @author      Fajar Agus Maulana
 * @copyright   Copyright (c) 2022, https://github.com/fajaramaulana/
 * @link 		https://github.com/fajaramaulana/
 */

namespace App\Http\Controllers;

use App\Models\Msds;
use App\Models\Departement;
use App\Models\Listjasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MsdsController extends Controller
{
    public function index(Request $request)
    {
        $reqId = $request->get('departement_id');
        $departements = Departement::select('id', 'name')->orderBy('name', 'desc')->get();
        if ($request->ajax()) {
            $data = Msds::join('departements', 'Msds.departement_id', '=', 'departements.id')
                ->select('departements.name', 'msds.id', 'msds.chemical_common_name', 'msds.sds_issue_date', 'msds.expired_date', 'msds.chemical_supplier', 'msds.cas_number');
            if ($request->get('departement_id') || $request->get('departement_id') == '0') {
                $data = $data->where('departement_id', $request->get('departement_id'));
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->cas_number . '\')">Edit</button> <button class="btn btn-sm btn-primary" onclick="return detail(' . $row->id . ')">Detail</button>';

                    return $btn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('admin.msds.index', [
            "departements" => $departements,
            "reqId" => $reqId
        ]);
    }

    public function create()
    {
        $departements = Departement::select('id', 'name')->orderBy('name', 'desc')->get();
        return view('admin.msds.create', [
            "departements" => $departements,
        ]);
    }

    public function store(Request $request)
    {
        $rules = array(
            'departement_id' => 'required',
            'chemical_common_name' => 'required',
            'trade_name' => 'required',
            'hsno_class' => 'required',
            'sds_issue_date' => 'required',
            'un_number' => 'required',
            'cas_number' => 'required',
            'chemical_supplier' => 'required',
            'quantity_volume' => 'required',
            'concentration' => 'required',
            'packaging_size' => 'required',
            'type_of_container' => 'required',
            'location_of_chemical' => 'required',
            'bulk_storage_tank' => 'required',
            'signage_in_place' => 'required',
            'bund_capacity' => 'required',
            'bunding_material' => 'required',
            'comments_other' => 'required',
            'dokumen' => 'mimes:pdf,docx,doc,xls,xlsx|required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            if ($request->departement_id == 0) {
                return [
                    'success' => 2,
                    'message' => "Anda Harus Pilih Departement Terlebih dahulu."
                ];
            }
            $dokumen = $request->file('dokumen');
            $extension = $request->file('dokumen')->guessExtension();
            $newGambarName = slugify($request->cas_number) . "-" . randString(4) . "." . $extension;
            $pathImage = public_path('dokumen') . '\\' . $newGambarName;
            try {
                $dokumen->move(public_path('dokumen') . '\\', $newGambarName);
                DB::beginTransaction();
                try {
                    $expiredDate = Carbon::parse($request->sds_issue_date)->addDays(365)->format('Y-m-d');
                    Msds::create([
                        'departement_id' => $request->departement_id,
                        'chemical_common_name' => $request->chemical_common_name,
                        'trade_name' => $request->trade_name,
                        'hsno_class' => $request->hsno_class,
                        'sds_issue_date' => $request->sds_issue_date,
                        'expired_date' => $expiredDate,
                        'un_number' => $request->un_number,
                        'cas_number' => $request->cas_number,
                        'chemical_supplier' => $request->chemical_supplier,
                        'quantity_volume' => $request->quantity_volume,
                        'concentration' => $request->concentration,
                        'packaging_size' => $request->packaging_size,
                        'type_of_container' => $request->type_of_container,
                        'location_of_chemical' => $request->location_of_chemical,
                        'bulk_storage_tank' => $request->bulk_storage_tank,
                        'signage_in_place' => $request->signage_in_place,
                        'bund_capacity' => $request->bund_capacity,
                        'bunding_material' => $request->bunding_material,
                        'comments_other' => $request->comments_other,
                        'path_pdf' => $newGambarName

                    ]);
                } catch (\Throwable $th) {
                    unlink($pathImage);
                    DB::rollback();
                    return [
                        'success' => 2,
                        'message' => "Error on store data to database. \n" . $th->getMessage()
                    ];
                }
            } catch (\Throwable $th) {
                DB::rollback();
                unlink($pathImage);
                return [
                    'success' => 2,
                    'message' => "Error on store image to storage. \n" . $th->getMessage()
                ];
            }
            DB::commit();
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
            "msds" => $bahan
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
                if ($request->gambar == null && $request->status == 1 && $bahanUp['image'] == "") {
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
