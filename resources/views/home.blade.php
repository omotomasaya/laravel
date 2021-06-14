@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>name: {!! Auth::user()->name !!}</p>
                    <p>email: {!! Auth::user()->email !!}</p>

                    <a href="{{ route('allProducts')}}"  class="btn btn-warning">筋SHOPへ</a>

                    @if(Auth::user()->admin == 1)

                    <a href="{{ route('adminDisplayProducts')}}" class="btn btn-primary">管理画面</a>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
