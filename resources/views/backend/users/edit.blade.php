@extends('backend.master')
@section('body')
<div class="row">
    <div class="col-md-12">
        <form method="post" action="{{route('users.update',$user->id)}}" id="edit_form">
            @csrf
            <div class="tile">
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger" title="this field is required">*</span></label>
                            <input class="form-control" id="name" name="name" type="text" value="{{$user->name}}">
                            @error('name')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="{{$user->email}}">
                            @error('email')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone <span class="text-danger" title="this field is required">*</span></label>
                            <input class="form-control" id="phone" name="phone" type="text" value="{{$user->phone}}">
                            @error('phone')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cv_link">CV Link <span class="text-danger" title="this field is required">*</span></label>
                            <input class="form-control" id="cv_link" name="cv_link" type="text" value="{{$user->cv_link}}">
                            @error('cv_link')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger" title="this field is required">*</span></label>
                            <select class="form-control" name="status" id="status">
                                <option value="0" @php echo($user->status == 0) ? 'selected' : '' @endphp>Pending</option>
                                <option value="1" @php echo($user->status == 1) ? 'selected' : '' @endphp>Approved</option>
                                <option value="2" @php echo($user->status == 2) ? 'selected' : '' @endphp>Reject</option>
                            </select>
                            @error('status')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="tile-footer text-right">
                    <button class="btn btn-primary" id="submit_btn" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
  </div>
@endsection
@section('extra_js')
<script type="text/javascript">
        $("#edit_form").on('submit', function() {
        let spinner = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`;
        $("#submit_btn").html(spinner);
        $('#submit_btn').prop('disabled', true);
        });
</script>
@endsection