@extends('sample')
@section('content')

    <div class="container">
        <div class="container">
            <table class="tabel table-striped">
                <thead class="thead-dark">
                    <td> Transaction id</td>
                    <td>Transaction Type</td>
                    <td> From </td>
                    <td>To</td>
                    <td>Transaction Date</td>
                </thead>
                    @foreach ($result as $results)
                        <tr>
                            <td>{{$results->name}}</td>
                        </tr>
                    @endforeach
                    
            </table>
        </div>
    </div>
@endsection