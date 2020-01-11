@extends('sample')

@section('content')
<div class="container">
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <div class="wrapper">
                    <form action="transactions" class="form-inline ml-3" method="POST">
                        @csrf
                        <div class="input-group">
                            <input class="form-control form-control-navbar" name="search" type="text" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @foreach ($transactions as $item)
                <table class="table">
                    <thead class="thead">
                        <td>id</td>
                        <td>type</td>
                        <td>amount</td>
                        <td>date</td>
                    </thead>
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->type}}</td>
                    </tr>
                </table>
            @endforeach
        </div>
    </div>
</div>
@endsection