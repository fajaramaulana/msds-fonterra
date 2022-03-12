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
                        <span class="sep"></span>
                        <span class="trail-end">Frequently Asked Questions</span>
                    </div>
                </div>
            </div>
            <div class="featured-title-heading-wrap">
                <h1 class="feautured-title-heading">
                    Pertanyaan yang sering ditanyakan
                </h1>
            </div>
        </div>
    </div>         
</div>
<div id="main-content" class="site-main clearfix">
    <div id="content-wrap" class="container">
        <div class="lasercuts-headings style-2 clearfix">
            <h2 class="heading">Pertanyaan Yang Sering Ditanyakan</h2>
            <div class="sep has-width w80 accent-bg clearfix"></div>                                           
            <p class="sub-heading font-size-16 line-height-28 text-666 margin-top-27 letter-spacing-01">Temukan jawaban untuk pertanyaan-pertanyaan yang sering diajukan oleh costumer lainnya.</p>
        </div>
        <div class="lasercuts-spacer clearfix" data-desktop="73" data-mobile="60" data-smobile="60"></div>
        <div class="lasercuts-accordions style-4 has-icon icon-right iconstyle-1 clearfix">
            @foreach ($faqs as $faq)
            <div class="accordion-item active">
                <h3 class="accordion-heading"><span class="inner">{{$faq->question}}</span></h3>
                <div class="accordion-content clearfix">
                    <div class="lasercuts-row clearfix">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="name">{{$faq->answer}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="lasercuts-spacer clearfix" data-desktop="73" data-mobile="60" data-smobile="60"></div>
    </div>
</div>
@endsection
