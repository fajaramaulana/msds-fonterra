@extends('frontend.master')
@section('title', $metas['title'])
@section('meta-title', $metas['title'])
@section('meta-description', $metas['description'])
@section('meta-keyword', $metas['keyword'])

@section('content')
    <div id="featured-title" class="featured-title clearfix">
        <div id="featured-title-inner" class="container clearfix">
            <div class="featured-title-inner-wrap">                    
                <div id="breadcrumbs">
                    <div class="breadcrumbs-inner">
                        <div class="breadcrumb-trail">
                            <a href="/" class="trail-begin" title="Home">Home</a>
                            <span class="sep">|</span>
                            <span class="trail-end">Kontak</span>
                        </div>
                    </div>
                </div>
                <div class="featured-title-heading-wrap">
                    <h1 class="feautured-title-heading">
                        Kontak
                    </h1>
                </div>
            </div>
        </div>         
    </div>
    <div id="main-content" class="site-main clearfix">
        <div id="content-wrap">
            <div id="site-content" class="site-content clearfix">
                <div id="inner-content" class="inner-content-wrap">
                   <div class="page-content">
                        <div class="row-iconbox">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lasercuts-spacer clearfix" data-desktop="61" data-mobile="60" data-smobile="60"></div>
                                        <div class="lasercuts-headings style-1 text-center clearfix">
                                            <h2 class="heading">Hubungi Kami</h2>
                                            <div class="sep has-icon width-125 clearfix">
                                                <div class="sep-icon">
                                                    <span class="sep-icon-before sep-center sep-solid"></span>
                                                    <span class="icon-wrap"><i class="laser-icon-build"></i></span>
                                                    <span class="sep-icon-after sep-center sep-solid"></span>
                                                </div>
                                            </div>
                                            <p class="sub-heading font-weight-400 max-width-770 line-height-26 margin-top-14">Butuh bantuan? Tim kami sangat siap untuk melayani kebutuhan anda, segera tanyakan kepada kami.</p>
                                        </div>
                                        <div class="lasercuts-spacer clearfix" data-desktop="45" data-mobile="35" data-smobile="35"></div>
                                    </div>
                                </div>
                                <div class="row gutter-16">
                                    <div class="col-md-4">
                                        <div class="lasercuts-icon-box icon-top align-center  accent-color style-3 bg-light-snow clearfix">
                                            <div class="icon-wrap">
                                                <i class="icon-phone"></i>
                                            </div>
                                            <div class="text-wrap">
                                                <h3 class="heading">(+62) 812 9588 5962</h3>
                                                <p class="sub-heading">Whatsapp Atau Telfon</p>
                                                <span class="class more-link">Whatsapp Kami Sekarang</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="lasercuts-spacer clearfix" data-desktop="0" data-mobile="0" data-smobile="35"></div>
                                        <div class="lasercuts-icon-box icon-top align-center accent-color style-3 bg-light-snow clearfix">
                                            <div class="icon-wrap">
                                                <i class="icon-map"></i>
                                            </div>
                                            <div class="text-wrap">
                                                <h3 class="heading">Jl. Tugu Karya I No.269, RT.005/RW.003, Cipondoh, Kec. Cipondoh, Kota Tangerang, Banten 15122</h3>
                                                <p class="sub-heading">Senin - Minggu: 9:00 am to 16:30 pm</p>
                                                <span class="class more-link"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="lasercuts-spacer clearfix" data-desktop="0" data-mobile="0" data-smobile="35"></div>
                                        <div class="lasercuts-icon-box icon-top align-center accent-color style-3 bg-light-snow clearfix">
                                            <div class="icon-wrap">
                                                <i class="icon-envelope"></i>
                                            </div>
                                            <div class="text-wrap">
                                                <h3 class="heading">info@scalinelasercutting.com</h3>
                                                <span class="class more-link">Mail us now</span>
                                            </div>
                                        </div>
                                    </div>               
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lasercuts-spacer clearfix" data-desktop="58" data-mobile="35" data-smobile="35"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-contact">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:center;">
                                        <div class="lasercuts-spacer clearfix" data-desktop="0" data-mobile="0" data-smobile="35"></div>
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.90956083527203!2d106.66910423189438!3d-6.190519565319028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f9043007db6d%3A0xc5305b8aa5d32295!2sJl.%20Tugu%20Karya%20I%2C%20Cipondoh%2C%20Kec.%20Cipondoh%2C%20Kota%20Tangerang%2C%20Banten%2015122!5e0!3m2!1sen!2sid!4v1640798189632!5m2!1sen!2sid" width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        <div class="lasercuts-spacer clearfix" data-desktop="50" data-mobile="50" data-smobile="35"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
