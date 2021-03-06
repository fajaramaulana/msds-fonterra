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
            $data = Msds::join('departements', 'msds.departement_id', '=', 'departements.id')
                ->select('departements.name', 'msds.id', 'msds.signage_doc', 'msds.chemical_common_name', 'msds.sds_issue_date', 'msds.expired_date', 'msds.chemical_supplier', 'msds.cas_number', 'msds.created_at')->where('active_status', 1);
            if ($request->get('departement_id') || $request->get('departement_id') == '0') {
                $data = $data->where('departement_id', $request->get('departement_id'));
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning" onclick="return edit(' . $row->id . ')" title="Edit"><i class="fas fa-pencil-alt"></i></button> <button class="btn btn-sm btn-danger" onclick="return hapus(' . $row->id . ')" title="Delete"><i class="fas fa-trash-alt"></i></button> <button type="button" style="margin-top: 5px;" class="btn btn-info btn-sm" data-toggle="modal"  data-target="#toggle-modal" title="Detail" data-throw="' . $row->id . '"><i class="fas fa-eye"></i></button>';

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
        );

        if ($request->dokumen != null) {
            $rules['dokumen']  = 'mimes:pdf,docx,doc,xls,xlsx|required';
        }

        if ($request->signage_doc != null) {
            $rules['dokumen']  = 'mimes:pdf,docx,doc,xls,xlsx';
        }


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
            if ($dokumen !== null) {
                $extension = $request->file('dokumen')->guessExtension();
                $newGambarName = slugify($request->cas_number) . "-" . randString(4) . "." . $extension;
                $pathImage = public_path('dokumen') . '\\' . $newGambarName;
            }

            $signageDoc = $request->file('signage_doc');
            if ($signageDoc !== null) {
                $extensionDoc = $request->file('signage_doc')->guessExtension();
                $newSignageDoc = slugify($request->cas_number) . "-" . randString(4) . "." . $extensionDoc;
                $pathSignage = public_path('dokumen') . '\\' . $newSignageDoc;
            }

            try {
                if ($dokumen !== null) {
                    $dokumen->move(public_path('dokumen') . '\\', $newGambarName);
                }

                if ($signageDoc !== null) {
                    $signageDoc->move(public_path('dokumen') . '\\', $newSignageDoc);
                }

                DB::beginTransaction();
                try {
                    $expiredDate = Carbon::parse($request->sds_issue_date)->addDays(1825)->format('Y-m-d');
                    $msds_id = Msds::create([
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
                        'path_pdf' => ($dokumen == null ? null : $newGambarName),
                        'signage_doc' => ($signageDoc == null ? null : $newSignageDoc),
                        'active_status' => 1,
                    ]);

                    DB::table('table_email_notify')->insert([
                        'msds_id' => $msds_id->id,
                        'departement_id' => $request->departement_id,
                    ]);
                } catch (\Throwable $th) {
                    @unlink($pathImage);
                    @unlink($pathSignage);
                    DB::rollback();
                    return [
                        'success' => 2,
                        'message' => "Error on store data to database. \n" . $th->getMessage()
                    ];
                }
            } catch (\Throwable $th) {
                DB::rollback();
                @unlink($pathImage);
                @unlink($pathSignage);
                return [
                    'success' => 2,
                    'message' => "Error on store image to storage. \n" . $th->getMessage()
                ];
            }
            DB::commit();
            return [
                'success' => 1,
                'message' => "Success Insert MSDS"
            ];
        }
    }

    public function edit($id)
    {
        $departements = Departement::select('id', 'name')->orderBy('name', 'desc')->get();
        $msds = Msds::select('*')->findorfail($id);
        return view('admin.msds.edit', [
            "departements" => $departements,
            "msds" => $msds
        ]);
    }

    public function getbyid(Request $request)
    {
        $id = $request->get('idlog');
        $msds = Msds::select('*')->findorfail($id);
        return response()->json($msds);
    }

    public function removePdfMsds(Request $request)
    {
        $idMsds = $request->id;
        $msds = Msds::where('id', $idMsds)->select('path_pdf')->get();
        $msdsUpdate = Msds::findOrFail($idMsds);
        $pathPdf = public_path('dokumen') . '\\'  . $msds[0]['path_pdf'];

        try {
            @unlink($pathPdf);
            try {
                $msdsUpdate->update([
                    'path_pdf' => null,
                ]);
                return [
                    'success' => 1,
                    'message' => "Success Remove PDF"
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

    public function removeSignagePdfMsds(Request $request)
    {
        $idMsds = $request->id;
        $msds = Msds::where('id', $idMsds)->select('signage_doc')->get();
        $msdsUpdate = Msds::findOrFail($idMsds);
        $pathPdf = public_path('dokumen') . '\\'  . $msds[0]['signage_doc'];

        try {
            @unlink($pathPdf);
            try {
                $msdsUpdate->update([
                    'signage_doc' => null,
                ]);
                return [
                    'success' => 1,
                    'message' => "Success Remove Signage Doc"
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


    public function update(Request $request, Msds $bahan)
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
            'bunding_material' => 'required'
        );

        if ($request->dokumen != null) {
            $rules['dokumen']  = 'mimes:pdf,docx,doc,xls,xlsx|required';
        }

        if ($request->signage_doc != null) {
            $rules['dokumen']  = 'mimes:pdf,docx,doc,xls,xlsx';
        }

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
            $signageDoc = $request->file('signage_doc');
            if ($dokumen !== null) {
                $extension = $request->file('dokumen')->guessExtension();
                $newGambarName = slugify($request->cas_number) . "-" . randString(4) . "." . $extension;
                $pathImage = public_path('dokumen') . '\\' . $newGambarName;

                if ($signageDoc !== null) {
                    $extensionDoc = $request->file('signage_doc')->guessExtension();
                    $newSignageDoc = slugify($request->cas_number) . "-" . randString(4) . "." . $extensionDoc;
                    $pathSignage = public_path('dokumen') . '\\' . $newSignageDoc;
                } else {
                    $newSignageDoc = $request->signage_doc_existing;
                }

                try {
                    $dokumen->move(public_path('dokumen') . '\\', $newGambarName);
                    if ($signageDoc !== null) {
                        $signageDoc->move(public_path('dokumen') . '\\', $newSignageDoc);
                    }
                    DB::beginTransaction();
                    try {
                        $expiredDate = Carbon::parse($request->sds_issue_date)->addDays(1825)->format('Y-m-d');
                        $msdsUpdate = Msds::findOrFail($request->id);
                        $msdsUpdate->update([
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
                            'path_pdf' => $newGambarName,
                            'signage_doc' => $newSignageDoc,
                            'active_status' => 1,
                        ]);
                    } catch (\Throwable $th) {
                        unlink($pathImage);
                        unlink($pathSignage);
                        DB::rollback();
                        return [
                            'success' => 2,
                            'message' => "Error on store data to database. \n" . $th->getMessage()
                        ];
                    }
                } catch (\Throwable $th) {
                    DB::rollback();
                    unlink($pathImage);
                    unlink($pathSignage);
                    return [
                        'success' => 2,
                        'message' => "Error on store image to storage. \n" . $th->getMessage()
                    ];
                }
                DB::commit();
                return [
                    'success' => 1,
                    'message' => "Success update MSDS"
                ];
            } else {
                DB::beginTransaction();
                if ($signageDoc !== null) {
                    $extensionDoc = $request->file('signage_doc')->guessExtension();
                    $newSignageDoc = slugify($request->cas_number) . "-" . randString(4) . "." . $extensionDoc;
                    $pathSignage = public_path('dokumen') . '\\' . $newSignageDoc;
                } else {
                    $newSignageDoc = $request->signage_doc_existing;
                }

                try {
                    if ($signageDoc !== null) {
                        $signageDoc->move(public_path('dokumen') . '\\', $newSignageDoc);
                    }
                    $expiredDate = Carbon::parse($request->sds_issue_date)->addDays(1825)->format('Y-m-d');
                    $msdsUpdate = Msds::findOrFail($request->id);
                    $msdsUpdate->update([
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
                        'signage_doc' => $newSignageDoc,
                    ]);
                } catch (\Throwable $th) {
                    DB::rollback();
                    unlink($pathSignage);
                    return [
                        'success' => 2,
                        'message' => "Error on store data to database. \n" . $th->getMessage()
                    ];
                }
                DB::commit();
                return [
                    'success' => 1,
                    'message' => "Success update MSDS"
                ];
            }
        }
    }


    public function destroy($id)
    {
    }

    public function inactive(Request $request)
    {
        $msds = Msds::findOrFail($request->id);
        try {
            $msds->update([
                'active_status' => 0
            ]);
        } catch (\Throwable $th) {
            return [
                'success' => 2,
                'message' => "Error on store data to database. \n" . $th->getMessage()
            ];
        }
        return [
            'success' => 1,
            'message' => "Success inactive MSDS"
        ];
    }
}
