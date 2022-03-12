@extends('frontend.master')
@section('title', $metas['title'])
@section('meta-title', $metas['title'])
@section('meta-description', $metas['description'])
@section('meta-keyword', $metas['keyword'])

@section('content')
    <!-- Featured Title -->
    <div id="featured-title" class="featured-title clearfix">
        <div id="featured-title-inner" class="container clearfix">
            <div class="featured-title-inner-wrap">
                <div id="breadcrumbs">
                    <div class="breadcrumbs-inner">
                        <div class="breadcrumb-trail">
                            <a href="index.html" class="trail-begin">Home</a>
                            <span class="sep">|</span>
                            <span class="trail-end">Portofolio</span>
                        </div>
                    </div>
                </div>
                <div class="featured-title-heading-wrap">
                    <h1 class="feautured-title-heading">
                        Portofolio Pengerjaan Kami
                    </h1>
                </div>
            </div><!-- /.featured-title-inner-wrap -->
        </div><!-- /#featured-title-inner -->
    </div>
    <!-- End Featured Title -->
    <div id="main-content" class="site-main clearfix">
        <div id="content-wrap">
            <div id="site-content" class="site-content clearfix">
                <div id="inner-content" class="inner-content-wrap">
                    <div class="page-content">
                        <!-- SERVICES -->
                        <div class="row-services">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="lasercuts-spacer clearfix" data-desktop="73" data-mobile="60"
                                            data-smobile="60"></div>
                                        <ul class="lasercuts-filter style-1 clearfix">
                                            <li class="active"><a href="#" data-filter="*">All</a></li>
                                            @foreach ($jasas as $jasa)
                                                <li><a href="#"
                                                        data-filter=".{{ slugify($jasa->name) }}">{{ $jasa->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="lasercuts-spacer clearfix" data-desktop="40" data-mobile="35"
                                            data-smobile="35"></div>
                                        <div
                                            class="lasercuts-project style-2 isotope-project has-margin mg15 data-effect clearfix">
                                            @foreach ($portofolios as $porto)
                                            <div class="project-item {{ slugify($porto->jasa) }}">
                                                <div class="inner">
                                                    <div
                                                        class="thumb data-effect-item has-effect-icon w40 offset-v-19 offset-h-49">
                                                        <img src="{{ env('PATH_IMAGE'). $porto->image }}" alt="{{$porto->name}}" height="360px" width="100%">
                                                    </div>
                                                    <div class="text-wrap">
                                                        <h5 class="heading"><a href="#" onclick="showDetail('{{ env('PATH_IMAGE'). $porto->image }}')">{{$porto->name}}</a></h5>
                                                        <div class="elm-meta">
                                                            <span>{{$porto->jasa}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="lasercuts-spacer clearfix" data-desktop="72" data-mobile="60"
                                            data-smobile="60"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let showDetail = (val) => {
            window.open(val)
        }
    </script>
@endsection
