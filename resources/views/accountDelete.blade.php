@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">アカウント削除</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>一度削除したらアカウントは元に戻りませんが、よろしいですか？</p>

                    <form action="{{ route('delete') }}" method="get">
                        @csrf
                        <p>
                            <input type="test" name="email" placeholder="メールアドレス">
                        </p>
                        <p>
                        　　<input type="password" name="password" placeholder="パスワード">
                      　</p>
                      　<p>
                        　　<input type="password" name="passConfirm" placeholder="パスワード確認">
                      　</p>
                      　<p>
                        　　<input type="submit" class="btn btn-danger" name="delete" value="削除">
                      　</p>
                        <div class="text-danger">
                            {{ session('error') }}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
