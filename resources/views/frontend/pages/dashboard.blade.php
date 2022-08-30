@extends('frontend.master')
@section('body')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center pt-5">
            <h2 class="section-heading text-uppercase">Dashboard</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(Session::get('error'))
                        <div class="alert alert-danger">
                        {{Session::get('error')}}
                        </div>
                    @endif
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                        {{Session::get('success')}}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            @php 
                                $submission_quiz_ids = auth()->guard('user')->user()->submissions->pluck('quiz_id')->toArray();
                            @endphp 
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
                                                @if(in_array($quiz->id,$submission_quiz_ids))
                                                    <a class="text-decoration-none">{{$quiz->title}}</a>
                                                    @else
                                                    <a class="text-decoration-none" href="{{route('quiz_show',$quiz->id)}}">{{$quiz->title}}</a>
                                                @endif
                                            </div>
                                            <div class="content">
                                                <div class="portfolio-caption-subheading text-muted">{{count($quiz->questions)}} Questions</div>
                                            </div>
                                            @if(in_array($quiz->id,$submission_quiz_ids))
                                                <a class="text-decoration-none btn btn-primary btn-sm" href="{{route('score',$quiz->id)}}">See Score</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                
                            @endforelse
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection