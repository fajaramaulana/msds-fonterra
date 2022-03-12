@extends('frontend.master')

@section('content')
    <section id="home" class="s-home page-hero target-section" data-parallax="scroll" data-image-src="{{ asset('frontend/images/fonterra.jpg')}}"
        data-natural-width=1000 data-natural-height=500 data-position-y=center>

        <div class="overlay"></div>
        <div class="shadow-overlay"></div>
        <div class="home-content">
            <div class="row home-content__main">
                <h3>Hello Fonterrians</h3>
                <h1>PT Fonterra Brands Manufacturing Indonesia</h1>
                <h1>E - SDS<br></h1>

                <div class="home-content__buttons">
                    <a href="#about" class="smoothscroll btn btn--stroke">
                        Apa itu SDS
                    </a>
                </div>

                <div class="home-content__scroll">
                    <a href="#about" class="scroll-link smoothscroll">
                        <span>Scroll Down</span>
                    </a>
                </div>
            </div>
        </div> <!-- end home-content -->

    </section> <!-- end s-home -->

    <!-- about
    ================================================== -->
    <section id="about" class="s-about target-section">

        <div class="row narrow section-intro has-bottom-sep">
            <div class="col-full text-center">
                <h1>Apa Itu SDS ?</h1>
                <p class="lead">SDS adalah dokumen yang memberikan informasi penting mengenai bahan kimia
                    berbahaya (Hazardous Substances) </p>
            </div>
        </div>

        <div class="masonry__brick">
            <div class="item-folio">
                <a href="https://www.behance.net/" class="item-folio__project-link" title="Project link">
                    <i class="im im-link"></i>
                </a>
                <span class="item-folio__caption">
                    <p>Vero molestiae sed aut natus excepturi. Et tempora numquam. Temporibus iusto quo.Unde dolorem
                        corrupti neque nisi.</p>
                </span>

            </div> <!-- end item-folio -->
        </div> <!-- end masonry__brick -->

    </section> <!-- end works -->

@endsection
