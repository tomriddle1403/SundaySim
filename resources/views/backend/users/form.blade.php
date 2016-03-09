@extends('layouts.backend')

@section('title', $user->exists ? 'Editing '.$user->name : 'Create New User')

@section('content')
	<div class="row">
		<div class="col-md-6">
				{!! Form::model($user, [
				'method' => $user->exists ? 'put' : 'post',
				'route' => $user->exists ? ['backend.users.update', $user->id] : ['backend.users.store']
				]) !!}

				<div class="form-group">
					{!! Form::label('name') !!}
					{!! Form::text('name', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('email') !!}
					{!! Form::text('email', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('password') !!}
					{!! Form::password('password', null, ['class' => 'form-control']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('password_confirmation') !!}
					{!! Form::password('password_confirmation', null, ['class' => 'form-control']) !!}
				</div>

				{!! Form::submit($user->exists ? 'Save User' : 'Create New User', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
		</div>
	</div>
	
	
@endsection