<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Partner;
use App\Models\Sejarah;
use App\Models\Info;
use App\Models\Banner;
use App\Models\Kontak;
use App\Models\Jamoperasional;
use App\Models\Visimisi;
use App\Models\Artilogo;
use App\Models\Bahan;
use App\Models\Kategoriproduk;
use App\Models\Regulasi;
use App\Models\Listproduk;
use App\Models\Dokumentasi;
use App\Models\Faq;
use App\Models\Listjasa;
use App\Models\Majalah;
use App\Models\Majalahdes;
use App\Models\StrukturKepengurusan as Struktur;
use App\Models\Pinjaman;
use App\Models\Pola;
use App\Models\Portofolio;
use App\Models\Testimoni;
use PHPUnit\Util\Json;

class BlogController extends Controller
{
    public function index()
    {
        $partner    = Partner::select('gambar', 'judul')->orderBy('created_at', 'desc')->get();
        $banner     = Banner::select('judul', 'gambar')->where('status', 1)->get();
        $listjasa   = Listjasa::select('name', 'description', 'image', 'slug')->where('status', 1)->get();
        $portofolio = Portofolio::join('listjasas', 'portofolios.id_jasa', '=', 'listjasas.id')->select('portofolios.name', 'listjasas.name as jasa', 'portofolios.image')->where('portofolios.status', 1)->latest('portofolios.created_at')->take(6)->get();
        $testimoni  = Testimoni::select('nama_pemesan', 'message')->where('status', 1)->latest()->take(6)->get();
        $meta       = array(
            "title" => "Scaline Laser Cutting Tangerang",
            "description" => "Kami menyediakan jasa pembuatan Laser Cutting, CNC, Pembuatan Railing Tangga, dan Neon Box Terbaik, Profesional dan Berkualitas Jakarta, Tangerang",
            "keyword" => "Jasa Pembuatan Laser Cutting, Jasa Pembuatan Railing Tangga, Jasa Pembuatan Neon Box, Laser Cutting Jakarta, Laser Cutting Tangerang, Laser Cutting Bogor, Harga Neon Box, Harga Laser Cutting, Laser Cutting Murah, Neon Box Murah, Design Railing Tangga, Pembuatan Railing Tangga, Pembuatan Railing Tangga Jakarta, Pembuatan Railing Tangga Tangerang, Jasa Laser Cutting Tangerang, Jasa Laser Cutting Jakarta, Jasa Laser Cutting Terbaik, Jasa Laser Cutting Cipondoh, Jasa Laser Cutting Ciledug, jasa laser cutting terbaik di tangerang, jasa laser cutting terbaik di jakarta, jasa laser cutting jakarta, jasa laser cutting tangerang"
        );
        return view('frontend.welcome-page', [
            "partners"  => $partner,
            "banners"   => $banner,
            "listjasas" => $listjasa,
            "portofolios" => $portofolio,
            "testimonis" => $testimoni,
            "metas" => $meta
        ]);
    }

    public function layanan()
    {
        $meta       = array(
             "title" => "Scaline Laser Cutting Tangerang",
            "description" => "Kami menyediakan jasa pembuatan Laser Cutting, CNC, Pembuatan Railing Tangga, dan Neon Box Terbaik, Profesional dan Berkualitas Jakarta, Tangerang",
            "keyword" => "Jasa Pembuatan Laser Cutting, Jasa Pembuatan Railing Tangga, Jasa Pembuatan Neon Box, Laser Cutting Jakarta, Laser Cutting Tangerang, Laser Cutting Bogor, Harga Neon Box, Harga Laser Cutting, Laser Cutting Murah, Neon Box Murah, Design Railing Tangga, Pembuatan Railing Tangga, Pembuatan Railing Tangga Jakarta, Pembuatan Railing Tangga Tangerang, Jasa Laser Cutting Tangerang, Jasa Laser Cutting Jakarta, Jasa Laser Cutting Terbaik, Jasa Laser Cutting Cipondoh, Jasa Laser Cutting Ciledug, jasa laser cutting terbaik di tangerang, jasa laser cutting terbaik di jakarta, jasa laser cutting jakarta, jasa laser cutting tangerang"
        );
        $listjasa   = Listjasa::select('name', 'description', 'image', 'slug')->where('status', 1)->get();
        return view('frontend.layanan', [
            "listjasas" => $listjasa,
            "metas" => $meta
        ]);
    }

    public function detail_layanan($slug)
    {
        $jasa       = Listjasa::where('slug', $slug)->get();
        $portofolios = Portofolio::where('id_jasa', $jasa[0]->id)->where('status', 1)->get();
        $bahans      = Bahan::where('id_jasa', $jasa[0]->id)->where('status', 1)->get();
        $faqs        = Faq::select('question', 'answer')->get();
        $polas       = Pola::where('id_jasa', $jasa[0]->id)->get();

        return view('frontend.layanandetail', [
            "jasa" => $jasa,
            "portofolios" => $portofolios,
            "bahans"    => (empty($bahans[0]) == true ? null : $bahans),
            "faqs"      => $faqs,
            "polas"     => (empty($polas[0]) == true ? null : $polas)
        ]);
    }

    public function portofolio()
    {
        $meta       = array(
             "title" => "Scaline Laser Cutting Tangerang",
            "description" => "Kami menyediakan jasa pembuatan Laser Cutting, CNC, Pembuatan Railing Tangga, dan Neon Box Terbaik, Profesional dan Berkualitas Jakarta, Tangerang",
            "keyword" => "Jasa Pembuatan Laser Cutting, Jasa Pembuatan Railing Tangga, Jasa Pembuatan Neon Box, Laser Cutting Jakarta, Laser Cutting Tangerang, Laser Cutting Bogor, Harga Neon Box, Harga Laser Cutting, Laser Cutting Murah, Neon Box Murah, Design Railing Tangga, Pembuatan Railing Tangga, Pembuatan Railing Tangga Jakarta, Pembuatan Railing Tangga Tangerang, Jasa Laser Cutting Tangerang, Jasa Laser Cutting Jakarta, Jasa Laser Cutting Terbaik, Jasa Laser Cutting Cipondoh, Jasa Laser Cutting Ciledug, jasa laser cutting terbaik di tangerang, jasa laser cutting terbaik di jakarta, jasa laser cutting jakarta, jasa laser cutting tangerang"
        );
        $portofolios = Portofolio::join('listjasas', 'portofolios.id_jasa', '=', 'listjasas.id')->select('portofolios.name', 'listjasas.name as jasa', 'portofolios.image')->where('portofolios.status', 1)->latest('portofolios.created_at')->get();
        $jasa       = Listjasa::select('name')->get();
        return view('frontend.portofolio', [
            "jasas" => $jasa,
            "portofolios" => $portofolios,
            "metas"     => $meta
        ]);
    }

    public function faq()
    {
        $meta       = array(
             "title" => "Scaline Laser Cutting Tangerang",
            "description" => "Kami menyediakan jasa pembuatan Laser Cutting, CNC, Pembuatan Railing Tangga, dan Neon Box Terbaik, Profesional dan Berkualitas Jakarta, Tangerang",
            "keyword" => "Jasa Pembuatan Laser Cutting, Jasa Pembuatan Railing Tangga, Jasa Pembuatan Neon Box, Laser Cutting Jakarta, Laser Cutting Tangerang, Laser Cutting Bogor, Harga Neon Box, Harga Laser Cutting, Laser Cutting Murah, Neon Box Murah, Design Railing Tangga, Pembuatan Railing Tangga, Pembuatan Railing Tangga Jakarta, Pembuatan Railing Tangga Tangerang, Jasa Laser Cutting Tangerang, Jasa Laser Cutting Jakarta, Jasa Laser Cutting Terbaik, Jasa Laser Cutting Cipondoh, Jasa Laser Cutting Ciledug, jasa laser cutting terbaik di tangerang, jasa laser cutting terbaik di jakarta, jasa laser cutting jakarta, jasa laser cutting tangerang"
        );

        $faqs       = Faq::select('question', 'answer')->get();
        return view('frontend.faqs', [
            "faqs" => $faqs,
            "metas"     => $meta
        ]);
    }

    public function kontak()
    {
        $meta       = array(
             "title" => "Scaline Laser Cutting Tangerang",
            "description" => "Kami menyediakan jasa pembuatan Laser Cutting, CNC, Pembuatan Railing Tangga, dan Neon Box Terbaik, Profesional dan Berkualitas Jakarta, Tangerang",
            "keyword" => "Jasa Pembuatan Laser Cutting, Jasa Pembuatan Railing Tangga, Jasa Pembuatan Neon Box, Laser Cutting Jakarta, Laser Cutting Tangerang, Laser Cutting Bogor, Harga Neon Box, Harga Laser Cutting, Laser Cutting Murah, Neon Box Murah, Design Railing Tangga, Pembuatan Railing Tangga, Pembuatan Railing Tangga Jakarta, Pembuatan Railing Tangga Tangerang, Jasa Laser Cutting Tangerang, Jasa Laser Cutting Jakarta, Jasa Laser Cutting Terbaik, Jasa Laser Cutting Cipondoh, Jasa Laser Cutting Ciledug, jasa laser cutting terbaik di tangerang, jasa laser cutting terbaik di jakarta, jasa laser cutting jakarta, jasa laser cutting tangerang"
        );

        return view('frontend.kontak', [
            "metas"     => $meta
        ]);
    }
}
