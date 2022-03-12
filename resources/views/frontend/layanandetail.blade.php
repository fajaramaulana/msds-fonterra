@extends('frontend.master')
@section('title', $jasa[0]['meta_title'])
@section('meta-title', $jasa[0]['meta_title'])
@section('meta-description', $jasa[0]['meta_description'])
@section('meta-keyword', $jasa[0]['meta_keywords'])

@section('content')
    <div id="featured-title" class="featured-title clearfix">
        <div id="featured-title-inner" class="container clearfix">
            <div class="featured-title-inner-wrap">
                <div id="breadcrumbs">
                    <div class="breadcrumbs-inner">
                        <div class="breadcrumb-trail">
                            <a href="{{ url('/') }}" class="trail-begin">Home</a>
                            <span class="sep">|</span>
                            <a href="{{ url('/layanan') }}" class="trail-begin">Layanan</a>
                            <span class="sep">|</span>
                            <span class="trail-end">{{ $jasa[0]['name'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="featured-title-heading-wrap">
                    <h1 class="feautured-title-heading">
                        {{ $jasa[0]['name'] }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="lasercuts-spacer clearfix" data-desktop="20" data-mobile="20" data-smobile="20"></div>
    <div id="main-content" class="site-main clearfix">
        <div id="content-wrap" class="container">
            <div id="site-content" class="site-content clearfix">
                <div id="inner-content" class="inner-content-wrap">
                    <div class="lasercuts-row equalize sm-equalize-auto clearfix">
                        <div class="span_1_of_6 bg-f7f">
                            <div class="lasercuts-spacer clearfix" data-desktop="60" data-mobile="60" data-smobile="60">
                            </div>
                            <div class="lasercuts-content-box clearfix" data-margin="0 10px 0 43px"
                                data-mobilemargin="0 15px 0 15px">
                                <div class="lasercuts-headings style-2 clearfix">
                                    <h2 class="heading font-size-28 line-height-39">{{ $jasa[0]['name'] }}</h2>
                                    <div class="sep has-width w80 accent-bg margin-top-20 clearfix"></div>
                                    <p class="sub-heading margin-top-33 line-height-24">{{ $jasa[0]['description'] }}</p>
                                </div>
                            </div>
                            <div class="lasercuts-spacer clearfix" data-desktop="56" data-mobile="56" data-smobile="56">
                            </div>
                        </div>
                        <div class="span_1_of_6 half-background style-2"
                            style="background-image: url({{ env('PATH_IMAGE') . $jasa[0]['image'] }}) !important">
                        </div>
                    </div>
                    <div class="lasercuts-spacer clearfix" data-desktop="37" data-mobile="35" data-smobile="35"></div>
                    @if ($bahans != null)
                        <div class="lasercuts-headings style-1 text-center clearfix">
                            <h2 class="heading">Bahan - Bahan</h2>
                            <p class="sub-heading font-weight-400 text-808 max-width-680">*Pelanggan dapat membawa bahan
                                sendiri, atau menggunakan bahan dari kami. Kami menyediakan berbagai bahan.</p>
                        </div>
                        <div class="lasercuts-spacer clearfix" data-desktop="39" data-mobile="35" data-smobile="35"></div>
                        <div class="lasercuts-carousel-box data-effect has-bullets bullet-circle bullet24 clearfix"
                            data-gap="30" data-column="3" data-column2="2" data-column3="1" data-auto="true">
                            <div class="owl-carousel owl-theme">
                                @foreach ($bahans as $bahan)
                                    <div class="lasercuts-team style-1 align-center clearfix">
                                        <div class="team-item">
                                            <div class="inner">
                                                <div class="thumb data-effect-item">
                                                    <img src="{{ env('PATH_IMAGE') . $bahan->image }}"
                                                        alt="{{ $bahan->nama_bahan }}" title="{{ $bahan->nama_bahan }}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3>{{ $bahan->nama_bahan }}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">{!! $bahan->description !!}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="lasercuts-spacer clearfix" data-desktop="39" data-mobile="35" data-smobile="35"></div>
                    <div class="flat-content-wrap style-2 clearfix">
                        <div class="lasercuts-row equalize sm-equalize-auto clearfix">
                            <div class="span_1_of_6"
                                style="background-image: url({{ asset('frontend/assets/img/detailed.jpg') }}) !important; width:40%; border-radius:5px;">
                            </div>
                            <div class="span_1_of_6" style="margin-left: 10px;">
                                <div class="lasercuts-spacer clearfix" data-desktop="10" data-mobile="10" data-smobile="10">
                                </div>
                                <h2 class="heading">Paket dari Jasa {{ $jasa[0]['name'] }} Kami Termasuk</h2>
                                <div class="lasercuts-spacer clearfix" data-desktop="8" data-mobile="8" data-smobile="8">
                                </div>
                                <div class="lasercuts-list has-icon style-1 icon-left size-16 clearfix mt-2">
                                    <div class="inner">
                                        <span class="item">
                                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                                            <h3 class="text-paket title" style="font-weight:400 !important;">Pembuatan Design</h3>
                                        </span>
                                    </div>
                                </div>
                                <div class="lasercuts-list has-icon style-1 icon-left size-16 clearfix mt-2">
                                    <div class="inner">
                                        <span class="item">
                                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                                            <h3 class="text-paket title" style="font-weight:400 !important;">Pengaplikasian Design Di Media</h3>
                                        </span>
                                    </div>
                                </div>
                                <div class="lasercuts-list has-icon style-1 icon-left size-16 clearfix mt-2">
                                    <div class="inner">
                                        <span class="item">
                                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                                            <h3 class="text-paket title" style="font-weight:400 !important;">Pengecatan</h3>
                                        </span>
                                    </div>
                                </div>
                                <div class="lasercuts-list has-icon style-1 icon-left size-16 clearfix mt-2">
                                    <div class="inner">
                                        <span class="item">
                                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                                            <h3 class="text-paket title" style="font-weight:400 !important;">Pengerjaan Yang Presisi</h3>
                                        </span>
                                    </div>
                                </div>
                                <div class="lasercuts-list has-icon style-1 icon-left size-16 clearfix mt-2">
                                    <div class="inner">
                                        <span class="item">
                                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                                            <h3 class="text-paket title" style="font-weight:400 !important;">Kustomisasi<span
                                                    style="color: red;">*</span></h3>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lasercuts-spacer clearfix" data-desktop="37" data-mobile="35" data-smobile="35"></div>
                    <!-- QUOTE -->
                    <div class="row-quote bg-row-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lasercuts-spacer clearfix" data-desktop="40" data-mobile="60"
                                        data-smobile="60"></div>
                                    <div class="lasercuts-quote style-1 clearfix">
                                        <div class="quote-item">
                                            <div class="inner">
                                                <div class="heading-wrap">
                                                    <h3 class="heading">Gratis Konsultasi! Segera Hubungi Kami
                                                        Untuk Penawaran Khusus.</h3>
                                                </div>
                                                <div class="button-wrap has-icon icon-left">
                                                    <a href="tel:+6281295885962" title="Hubungi Kami"
                                                        class="lasercuts-button bg-white small"><span>(+62)
                                                            812 9588 5962 <span class="icon"><i
                                                                    class="laser-icon-phone-contact"></i></span></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60"
                                        data-smobile="60"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60"></div>
                    @if ($polas != null)
                        <div class="row-services">
                            <div class="lasercuts-headings style-1 text-center clearfix">
                                <h2 class="heading">Beberapa Contoh Pola yang Kami Miliki</h2>
                            </div>
                            <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60">
                            </div>
                            <div class="container">
                                <div class="row">
                                    @foreach ($polas as $pola)
                                        <div class="col-md-4">
                                            <div class="lasercuts-image-box style-2 clearfix">
                                                <div class="image-box-item">
                                                    <div class="inner">
                                                        <div class="thumb">
                                                            <img src="{{ env('PATH_IMAGE') . $pola->image }}"
                                                                alt="{{ $pola->nama_pola }}" title="{{ $pola->nama_pola }}">
                                                            <div class="overlay-effect bg-color-accent"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60"></div>
                    @endif
                    <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60"></div>
                    <div class="detail-gallery">
                        <div class="flat-content-wrap style-3 text-center clearfix">
                            <h2 class="Heading">PORTOFOLIO PENGERJAAN {{ strtoupper($jasa[0]['name']) }} KAMI
                            </h2>
                        </div>
                        <div class="lasercuts-spacer clearfix" data-desktop="21" data-mobile="21" data-smobile="21"></div>
                        <div class="lasercuts-spacer clearfix" data-desktop="21" data-mobile="21" data-smobile="21"></div>
                        <div class="lasercuts-gallery style-2 has-arrows arrow-center arrow-circle offset-v-82 has-thumb w185 clearfix"
                            data-gap="0" data-column="1" data-column2="1" data-column3="1" data-auto="false">
                            <div class="owl-carousel owl-theme">
                                @foreach ($portofolios as $portofolio)
                                    <div class="gallery-item">
                                        <div class="inner">
                                            <div class="thumb">
                                                <img src="{{ env('PATH_IMAGE') . $portofolio->image }}"
                                                    onclick="showModal(this);" alt="{{ $portofolio->name }}" title="{{ $portofolio->name }}" style="overflow: hidden !important;">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="lasercuts-spacer clearfix" data-desktop="40" data-mobile="40" data-smobile="40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="lasercuts-spacer clearfix" data-desktop="0" data-mobile="0" data-smobile="35"></div>
                    <div class="lasercuts-content-box" data-margin="0 0 0 18px" data-mobilemargin="0 0 0 0">
                        <div class="lasercuts-headings style-1 clearfix">
                            <h2 class="heading">Yang Sering Ditanyakan</h2>
                            <div class="sep has-width w80 accent-bg margin-top-11 clearfix"></div>
                        </div>
                        <div class="lasercuts-spacer clearfix" data-desktop="10" data-mobile="10" data-smobile="10"></div>
                        <div class="lasercuts-accordions style-1 has-icon icon-left iconstyle-1 clearfix">
                            @foreach ($faqs as $faq)
                                <div class="accordion-item active">
                                    <h3 class="accordion-heading"><span
                                            class="inner">{{ $faq->question }}</span>
                                    </h3>
                                    <div class="accordion-content">
                                        <div>{{ $faq->answer }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60"></div>
                <div class="lasercuts-spacer clearfix" data-desktop="31" data-mobile="60" data-smobile="60"></div>
            </div>
        </div>
        <script>
            let showModal = (val) => {
                window.open(`${val.src}`)
            }
        </script>
    @endsection
