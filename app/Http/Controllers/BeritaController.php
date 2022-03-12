<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $user = Auth::user();
        
        if ($user->tipe == 0) {
            $beritas = Berita::where('user_id', $user->id)->paginate();      
        } else {
            $beritas = Berita::paginate();      
        }
      
        return view('admin.beritadashboard.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.beritadashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'rangkuman'=>'required', 
            'deskripsi' => 'required',
            'gambar' => 'required',
            ]);
        $gambar = $request->gambar;
        $new_gambar = time().$gambar->getClientOriginalName();

        $berita = Berita::create([
            'judul' => $request->judul,
            'rangkuman'=>$request->rangkuman,
            'deskripsi' => $request->deskripsi ,
            'gambar' => 'public/uploads/berita/'.$new_gambar,
            'slug' => Str::slug($request->judul),
            'user_id' => Auth::id()
        ]);

        $gambar->move('public/uploads/berita/', $new_gambar);
        return redirect()->route('beritadashboard.index')->with('success', 'Berita Berhasil disimpan');
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
        $berita = Berita::findorfail($id);
        return view('admin.beritadashboard.edit', compact('berita'));
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
            'rangkuman' => 'required',
            'deskripsi' => 'required',
            ]);
        

        $berita = Berita::findorfail($id);

        if($request->has('gambar')){
            $gambar = $request->gambar;
            $new_gambar = time().$gambar->getClientOriginalName();
            $gambar->move('public/uploads/berita/', $new_gambar);

            $berita_data = [
                'judul' => $request->judul,
                'rangkuman' => $request->rangkuman,
                'deskripsi' => $request->deskripsi ,
                'gambar' => 'public/uploads/berita/'.$new_gambar,
            ];
        }
        else{
            $berita_data = [
                'judul' => $request->judul, 
                'rangkuman' => $request->rangkuman,
                'deskripsi' => $request->deskripsi ,
            ];
        }

        
        $berita->update($berita_data);
       
        return redirect()->route('beritadashboard.index')->with('success', 'Berita Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);
        $berita->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
