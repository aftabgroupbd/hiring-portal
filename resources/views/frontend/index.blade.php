@extends('frontend.master')
@section('body')
<!-- Masthead-->
@include('frontend.layouts.banner')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Latest Quiz</h2>
        </div>
        @php 
        if(auth()->guard('user')->user())
        {
            $submission_quiz_ids = auth()->guard('user')->user()->submissions->pluck('quiz_id')->toArray();
        }
        @endphp 
        <div class="row justify-content-center">
            @forelse ($quizzes as $quiz)
                <div class="col-lg-4 col-sm-6 mb-4">
                    <!-- Portfolio item 1-->
                    <div class="portfolio-item">
                        <a class="portfolio-link">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="{{asset('/')}}assets/frontend/img/portfolio/1.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">
                                @if(auth()->guard('user')->user())
                                    @if(in_array($quiz->id,$submission_quiz_ids))
                                        <a class="text-decoration-none">{{$quiz->title}}</a>
                                        @else
                                        <a class="text-decoration-none" href="{{route('quiz_show',$quiz->id)}}">{{$quiz->title}}</a>
                                    @endif
                                @else 
                                    {{$quiz->title}}
                                @endif
                            </div>
                            <div class="content">
                                <div class="portfolio-caption-subheading text-muted">{{count($quiz->questions)}} Questions</div>
                            </div>
                            @if(auth()->guard('user')->user())
                                @if(in_array($quiz->id,$submission_quiz_ids))
                                    <a class="text-decoration-none btn btn-primary btn-sm" href="{{route('score',$quiz->id)}}">See Score</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                
            @endforelse
        </div>
    </div>
</section>
@endsection