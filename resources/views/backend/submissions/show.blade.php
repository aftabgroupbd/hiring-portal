@extends('backend.master')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="m-0">{{$title}} - Total Marks: {{count($submission->quiz->questions)}} - Obtain Marks: {{$submission->total_marks}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php 
                        $sl = 1;
                        $submission_answers = json_decode($submission->answers);
                    @endphp 
                    @forelse ($submission->quiz->questions as $question)
                        <div class="col-md-6 mb-2">
                            <p class="mb-1">{{$sl}}. {{$question->question}}</p>
                            <div class="options ml-2">
                                @forelse (json_decode($question->options) as $key=>$option)
                                <div class="form-check">
                                    <input type="radio" name="answer_{{$question->id}}" @php echo(($key + 1) == $submission_answers[$sl - 1]->std_answer) ? 'checked' : '' @endphp id="answer_{{$question->id}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$question->id}}">
                                    <label for="answer_{{$question->id}}_{{$key}}" class="form-check-label">{!! $option !!}</label>
                                </div>
                                @empty
                                    
                                @endforelse
                            </div>
                            <p class="my-1 p-1" style="font-weight: bold">Ans: {{$submission_answers[$sl - 1]->answer}}</p>
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
@endsection