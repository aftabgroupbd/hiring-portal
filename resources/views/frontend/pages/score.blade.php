@extends('frontend.master')
@section('body')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center pt-5">
            <h2 class="section-heading text-uppercase">Quiz Score</h2>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
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
                <div class="card">
                    <div class="card-header text-center">
                        {{$quiz->title}} - Total Marks: {{count($quiz->questions)}} - Obtain Marks: {{$submission->total_marks}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php 
                                $sl = 1;
                                $submission_answers = json_decode($submission->answers);
                            @endphp 
                            @forelse ($quiz->questions as $question)
                                <div class="col-md-6 mb-2">
                                    <p class="mb-1">{{$sl}}. {{$question->question}}</p>
                                    <div class="options">
                                        @forelse (json_decode($question->options) as $key=>$option)
                                        <div class="form-check">
                                            <input type="radio" name="answer_{{$question->id}}" @php echo(($key + 1) == $submission_answers[$sl - 1]->std_answer) ? 'checked' : '' @endphp id="answer_{{$question->id}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$question->id}}">
                                            <label for="answer_{{$question->id}}_{{$key}}" class="form-check-label">{!! $option !!}</label>
                                        </div>
                                        @empty
                                            
                                        @endforelse
                                    </div>
                                    <p class="my-1 fw-bold p-1">Ans: {{$submission_answers[$sl - 1]->answer}}</p>
                                </div>
                                @php 
                                    $sl++;
                                @endphp 
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