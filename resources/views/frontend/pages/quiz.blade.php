@extends('frontend.master')
@section('body')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center pt-5">
            <h2 class="section-heading text-uppercase">Quiz</h2>
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
                        {{$quiz->title}}
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('submit_quiz',$quiz->id)}}" id="submit_form">
                            @csrf
                            <div class="row">
                                @php 
                                    $sl = 1;
                                @endphp 
                                @forelse ($quiz->questions as $question)
                                    <div class="col-md-6 mb-4">
                                        <p class="mb-1">{{$sl}}. {{$question->question}}</p>
                                        <div class="options">
                                            @forelse (json_decode($question->options) as $key=>$option)
                                            <div class="form-check">
                                                <input type="radio" name="answer_{{$question->id}}" id="answer_{{$question->id}}_{{$key}}" value="{{$key+1}}" class="form-check-input answer answer_{{$question->id}}">
                                                <label for="answer_{{$question->id}}_{{$key}}" class="form-check-label">{!! $option !!}</label>
                                            </div>
                                            @empty
                                                
                                            @endforelse
                                        </div>
                                    </div>
                                    @php 
                                        $sl++;
                                    @endphp 
                                @empty
                                    
                                @endforelse    
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" id="submit_btn" class="btn btn-primary btn-sm">Submit</button>  
                                </div>  
                            </div>     
                        </form>  
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $("#submit_form").on('submit', function(e) {
        e.preventDefault();
        let spinner = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`;
        $("#submit_btn").html(spinner);
        $('#submit_btn').prop('disabled', true);
        $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data)
            {
                $('#submit_btn').html('Submit');
                if (data.error == true) {
                    if(data.check ==  true)
                    {
                        $.each(data.message, function( key, value ) {
                            $(".error_"+key).html(value);
                        });
                    }else{
                        swal({
                            text: data.message,
                            icon: "error",
                        });
                    }
                }else{
                    swal({
                        text: data.message,
                        icon: "success",
                    });
                    window.location.href = data.url;
                }
                $('#submit_btn').prop('disabled', false);
            }
        });
    });
</script>
@endsection