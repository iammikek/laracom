<section id="hero" class="hero-section top-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="hero-content">
                    <h1 class="hero-title">{{config('app.name')}} Cosmetics <br> Collection</h1>
                    <p class="hero-text">We sell All Cosmetics <strong class="text-success">FREE!</strong></p>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-8">

                @foreach($slides as $slide)
                    @if($loop->first)
                        <ul>
                            @endif

                            <li>
                                <img src="{{url('images').'/'.$slide->photo}}" alt="{{$slide->title}}"/>
                            </li>

                            @if($loop->last)
                        </ul>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>