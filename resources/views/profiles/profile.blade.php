@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $user->name }}'s Profile
			</div>
			<div class="panel-body">
				<img src="{{ Storage::url($user->avatar) }}" height="70" width="70" style="border-radius:50%" alt="">
				<p class="text-center">
					@if(Auth::id()==$user->id):
						<a href="{{ route('profile.edit') }}" class="btn btn-info">Edit Profile</a>
					@endif
				</p>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="body">
				<friend> </friend>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				About Me
			</div>
			<div class="panel-body">
				<p class="text-center">
					{{ $user->profile->location }}
				</p>
				<p class="text-center">
					{{ $user->profile->about }}
				</p>
			</div>
		</div>
	</div>
</div>

@endsection

