<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::select('id','question', 'answer', 'status', 'created_at');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button class="btn btn-sm btn-primary" onclick="return edit(' . $row->id . ', \'' . $row->question . '\')">Edit</button>';

                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? "Active" : "Non active";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.faq.index');
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'question' => 'required|min:5',
            'answer' => 'required|min:2',
        );

        $messages = array(
            'question.required' => 'Pertanyaan is required.',
            'question.min' => 'Pertanyaan min 5 character.',
            'answer.required' => 'Jawaban is required.',
            'answer.min' => 'Jawaban min 2 character.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            try {
                Faq::create([
                    'question' => $request->question,
                    'answer'  => $request->answer,
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
                'message' => "Success Create FAQ"
            ];
        }
    }


    public function edit($id)
    {
        $testimoni = Faq::select('id', 'question', 'answer','status')->findorfail($id);
        return view('admin.faq.edit', [
            "faq" => $testimoni
        ]);
    }


    public function update(Request $request, $id)
    {
        $rules = array(
            'question' => 'required|min:5',
            'answer' => 'required|min:2',
        );

        $messages = array(
            'question.required' => 'Pertanyaan is required.',
            'question.min' => 'Pertanyaan min 5 character.',
            'answer.required' => 'Jawaban is required.',
            'answer.min' => 'Jawaban min 2 character.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        } else {
            $testimoni = Faq::findorfail($id);
            $testimoni_data = [
                'question'  => $request->question,
                'answer'  => $request->answer,
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
                'message' => "Success Update FAQ"
            ];
        }
    }

    public function destroy($id)
    {
       
    }
}
