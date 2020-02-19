@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        Delete profile <strong>{{Auth::user()->name}}</strong>?
    </div>
    <div class="card-body">
        <form action='/profile/deleteProfile/yes' method='post'>
            @csrf
            <div class="form-group">
                <button class="form-control btn btn-outline-danger" type='submit' name='id' value='{{Auth::user()->id}}'>Yes</button>
            </div>
        </form>
        <form action='/profile/show/{{{Auth::user()->id}}}' method='get'>
            @csrf
            <div class="form-group">
                <button class="form-control bg-light" type='submit'name='id' value='{{Auth::user()->id}}'>No, take me back</button>
            </div>
        </form>
    </div>
</div>
@endsection
