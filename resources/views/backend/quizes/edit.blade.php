@extends('backend.master')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Create Quiz
            </div>
            <div class="card-body">
                <form method="PUT" action="{{route('admin.quizes.update',$quiz->id)}}" id="edit_quiz">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Title<span class="text-danger" title="this field is required">*</span></label>
                                <input class="form-control" id="title" name="title" value="{{$quiz->title}}" type="text" placeholder="Enter quiz title" />
                                <small class="form-text text-danger error_title"></small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="1" placeholder="Enter quiz description">{{$quiz->description}}</textarea>
                                <small class="form-text text-danger error_description"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status<span class="text-danger" title="this field is required">*</span></label>
                                <select class="form-control" id="status" name="status">
                                    <option @php echo($quiz->status == 1) ? 'selected' : '' @endphp value="1">Active</option>
                                    <option @php echo($quiz->status == 0) ? 'selected' : '' @endphp value="0">Deactive</option>
                                    <option @php echo($quiz->status == 2) ? 'selected' : '' @endphp value="2">Finished</option>
                                </select>
                                <small class="form-text text-danger error_status"></small>
                            </div>
                        </div>
                    </div>
                    <div id="question_content">
                        @php 
                            $questions = $quiz->questions;
                            $question_item = 1;
                            $letter = ['A','B','C','D'];
                        @endphp 
                        @forelse ($questions as $key=>$question)
                            <div class="card mt-3" id="question_item_{{$question_item}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="question_{{$question_item}}">Question {{$question_item}}</label>
                                                <input type="hidden" name="question_id[]" value="{{$question->id}}">
                                                <input type="hidden" name="quiz[{{$question_item - 1}}][id]" value="{{$question->id}}">
                                                <textarea class="form-control" id="question_{{$question_item}}" name="quiz[{{$question_item - 1}}][question]" rows="6" placeholder="Enter quiz question">{{$question->question}}</textarea>
                                                <small class="form-text text-danger error_question_{{$question_item}}"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                @forelse (json_decode($question->options) as $key=>$option)
                                                    <div class="col-md-3">
                                                        <div class="row text-center align-items-center">
                                                            <div class="col-9">
                                                                <div class="form-group">
                                                                    <label for="option_{{$question_item}}_1" style="width: 100%;background: #eee;color: #000;font-size: 20px;">{{$letter[$key]}}</label>
                                                                    <textarea class="form-control" id="option_{{$question_item}}_1" name="quiz[{{$question_item - 1}}][option][]" rows="5" placeholder="Enter option value">{{$option}}</textarea>
                                                                    <small class="form-text text-danger error_option_{{$question_item}}_1"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 pl-0">
                                                                <div class="form-group">
                                                                    <label for="answer_{{$question_item}}_1"></label>
                                                                    <input type="radio" name="quiz[{{$question_item - 1}}][answer]" @php echo(($key + 1) == $question->answer) ? 'checked' : '' @endphp  id="answer_{{$question_item}}_1" required value="{{$key + 1}}" style="text-align: center;width: 25px;height: 100px;line-height: 100px;">
                                                                    <small class="form-text text-danger error_answer_{{$question_item}}_1"></small>
                                                                </div>
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
                        @php 
                            $question_item ++;
                        @endphp 
                        @empty
                            
                        @endforelse
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="remove_question_item()"> - Remove Question</button>
                            <button type="button" class="btn btn-success btn-sm" onclick="add_question_item()"> + Add Question</button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" id="submit_btn" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
let question_item = {{$question_item - 1}};
add_question_item = () =>
{
    question_item++;

        var question_item_html = `
                <div class="card mt-3" id="question_item_${question_item}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="question_${question_item}">Question ${question_item}</label>
                                    <textarea class="form-control" id="question_${question_item}" name="quiz[${question_item - 1}][question]" rows="6" placeholder="Enter quiz question"></textarea>
                                    <small class="form-text text-danger error_question_${question_item}"></small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row text-center align-items-center">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="option_${question_item}_1" style="width: 100%;background: #eee;color: #000;font-size: 20px;">A</label>
                                                    <textarea class="form-control" id="option_${question_item}_1" name="quiz[${question_item - 1}][option][]" rows="5" placeholder="Enter option value"></textarea>
                                                    <small class="form-text text-danger error_option_${question_item}_1"></small>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <div class="form-group">
                                                    <label for="answer_${question_item}_1"></label>
                                                    <input type="radio" name="quiz[${question_item - 1}][answer]" id="answer_${question_item}_1" required value="1" style="text-align: center;width: 25px;height: 100px;line-height: 100px;">
                                                    <small class="form-text text-danger error_answer_${question_item}_1"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row text-center align-items-center">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="option_${question_item}_2" style="width: 100%;background: #eee;color: #000;font-size: 20px;">B</label>
                                                    <textarea class="form-control" id="option_${question_item}_2" name="quiz[${question_item - 1}][option][]" rows="5" placeholder="Enter option value"></textarea>
                                                    <small class="form-text text-danger error_option_${question_item}_2"></small>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <div class="form-group">
                                                    <label for="answer_${question_item}_2"></label>
                                                    <input type="radio" name="quiz[${question_item - 1}][answer]" id="answer_${question_item}_2" required value="2" style="text-align: center;width: 25px;height: 100px;line-height: 100px;">
                                                    <small class="form-text text-danger error_answer_${question_item}_2"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row text-center align-items-center">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="option_${question_item}_3" style="width: 100%;background: #eee;color: #000;font-size: 20px;">C</label>
                                                    <textarea class="form-control" id="option_${question_item}_3" name="quiz[${question_item - 1}][option][]" rows="5" placeholder="Enter option value"></textarea>
                                                    <small class="form-text text-danger error_option_${question_item}_3"></small>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <div class="form-group">
                                                    <label for="answer_${question_item}_3"></label>
                                                    <input type="radio" name="quiz[${question_item - 1}][answer]" id="answer_${question_item}_3" required value="3" style="text-align: center;width: 25px;height: 100px;line-height: 100px;">
                                                    <small class="form-text text-danger error_answer_${question_item}_3"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row text-center align-items-center">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="option_${question_item}_4" style="width: 100%;background: #eee;color: #000;font-size: 20px;">D</label>
                                                    <textarea class="form-control" id="option_${question_item}_4" name="quiz[${question_item - 1}][option][]" rows="5" placeholder="Enter option value"></textarea>
                                                    <small class="form-text text-danger error_option_${question_item}_4"></small>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <div class="form-group">
                                                    <label for="answer_${question_item}_4"></label>
                                                    <input type="radio" name="quiz[${question_item - 1}][answer]" id="answer_${question_item}_4" required value="4" style="text-align: center;width: 25px;height: 100px;line-height: 100px;">
                                                    <small class="form-text text-danger error_answer_${question_item}_4"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
        `;
        $("#question_content").append(question_item_html);
}
remove_question_item = () =>
{
    if(question_item > 1)
    {
        $(`#question_item_${question_item}`).remove();
        question_item--;
    }
}
    $("#edit_quiz").on('submit', function(e) {
        e.preventDefault();
        let spinner = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`;
        $("#submit_btn").html(spinner);
        $('#submit_btn').prop('disabled', true);
        $("#create_quiz small").html('');
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
                $('#submit_btn').html('<i class="fa fa-sign-in fa-lg fa-fw"></i>Submit');
                $("#create_quiz small").html('');
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
                    location.reload();
                }
                $('#submit_btn').prop('disabled', false);
            }
        });
    });
</script>
@endsection