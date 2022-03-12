<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partner = Partner::paginate(10);
        return view('admin.partner.index', compact('partner'));
    }

    public function create()
    {
        return view('admin.partner.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar' => 'required|mimes:jpeg,png,jpg:|max:1000',
        ]);
        $gambar = $request->file('gambar');
        $extension = $request->file('gambar')->guessExtension();
        $newGambarName = slugify($request->judul) . "-" . randString(4) . "." . $extension;
        $pathImage = base_path('..\mainData\partner\\') . $newGambarName;

        $partner = Partner::create([
            'judul' => $request->judul,
            'gambar' => 'partner/' . $newGambarName,
        ]);

        $gambar->move(base_path('..\mainData\partner'), $newGambarName);
        return redirect()->route('partner.index')->with('success', 'Partner Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::findorfail($id);
        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
        ]);


        $partner = Partner::findorfail($id);

        if ($request->has('gambar')) {
            $gambar = $request->gambar;
            $new_gambar = time() . $gambar->getClientOriginalName();
            $gambar->move('public/uploads/partner/', $new_gambar);

            $partner_data = [
                'judul' => $request->judul,
                'gambar' => 'public/uploads/partner/' . $new_gambar,
            ];
        } else {
            $partner_data = [
                'judul' => $request->judul
            ];
        }


        $partner->update($partner_data);

        return redirect()->route('partner.index')->with('success', 'Partner Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::findorfail($id);
        $partner->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
