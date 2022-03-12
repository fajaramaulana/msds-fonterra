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
                            <span class="trail-end">Layanan</span>
                        </div>
                    </div>
                </div>
                <div class="featured-title-heading-wrap">
                    <h1 class="feautured-title-heading">
                        Semua Layanan
                    </h1>
                </div>
            </div><!-- /.featured-title-inner-wrap -->
        </div><!-- /#featured-title-inner -->
    </div>
    <div class="lasercuts-spacer clearfix" data-desktop="45" data-mobile="60" data-smobile="60"></div>
    <div id="main-content" class="site-main clearfix">
        <div id="content-wrap">
            <div id="site-content" class="site-content clearfix">
                <div id="inner-content" class="inner-content-wrap">
                    <div class="page-content">
                        <div class="row-services">
                            <div class="container">
                                <div class="row">
                                    @foreach ($listjasas as $jasa)
                                        <div class="col-md-4" style="margin-bottom: 15px;">
                                            <div class="lasercuts-image-box style-2 clearfix">
                                                <div class="image-box-item">
                                                    <div class="inner">
                                                        <div class="thumb">
                                                            <img src="{{ env('PATH_IMAGE') . $jasa->image }}"
                                                                alt="{{ $jasa->name }}" title="{{ $jasa->name }}">
                                                            <div class="overlay-effect bg-color-accent"></div>
                                                        </div>
                                                        <div class="text-wrap">
                                                            <h2 class="heading">
                                                                <a href="{{ url('layanan/' . $jasa->slug) }}" title="{{ $jasa->name }}">{{ $jasa->name }}</a>
                                                            </h2>
                                                            <h3 class="letter-spacing-01">{{ $jasa->description }}</h3>
                                                            <div class="elm-readmore">
                                                                <a href="{{ url('layanan/' . $jasa->slug) }}"
                                                                    style="color: #495054;" title="{{ $jasa->name }}">KLIK
                                                                    DISINI</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="lasercuts-spacer clearfix" data-desktop="45" data-mobile="60"
                                        data-smobile="60"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
