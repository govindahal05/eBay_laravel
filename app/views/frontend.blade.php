@extends('layouts.frontend')

@section('content')
<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Member Login</h3>
      </div>
     <div class="panel-body">
  {{ Form::open(array('url' => 'login', 'class' => 'well')) }}
      <div class="form-group">
        {{Form::label('username','Username')}}
        {{ Form::text('username') }}
        {{$errors->first('username','<span class=error>:message</span>')}}
      </div>
    <div class="form-group">
        {{Form::label('password','Password')}}
        {{ Form::password('password') }}
      </div>
        {{ Form::submit('Login', array('class'=>'btn btn-info btn-block')) }}


{{ Form::close() }}
     </div>
<div class="text-center">
      <a href="/register" >Not Member? Register</a>
    </div>
</div>

</div>
</div>
@stop