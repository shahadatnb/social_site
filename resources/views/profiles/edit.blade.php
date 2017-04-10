@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
				  <div class="panel-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    	<div class="form-group">
                    		<label for="location">Upload Avatar</label>
                    		<input type="file" name="avatar" class="form-control" accept="image/*">
                    	</div>
                    	<div class="form-group">
                    		<label for="location">Location</label>
                    		<input type="text" name="location" value="{{ $info->location }}" class="form-control">
                    	</div>
                    	<div class="form-group">
                    		<label for="about">About Me</label>
                    		<textarea name="about" class="form-control">{{ $info->about }} </textarea>
                    	</div>
                    	<div class="form-group">
                    		<p class="text-center">
                    			<button class="btn btn-primary">Update Profile</button>
                    		</p>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
