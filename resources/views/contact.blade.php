@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Contact Manager') }}</div>

                <div class="card-body">
                    <form action="{{route('contact.store')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="to">Select Manager</label>
                            <select name="to" id="to" class="form-control" required>
                                <option value="" selected disabled>Select Manager</option>
                                @foreach (\Illuminate\Support\Facades\DB::table('users')->where('role', 'manager')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-sm float-right"><i class="fa fa-paper-plane"></i> Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
