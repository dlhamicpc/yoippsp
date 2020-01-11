@extends('sample')

@section('content')
@php

@endphp
    <div class="container">
        <div class="row">
            <div class="col-6">
                CHECK FOR THE ACCOUNT
            </div>
            @foreach ($persons as $item)
            <div class="container">
                    <div class="container">
                      <div class="col-md-12">
                      <div class="card card-warning">
                          <div class="card-header">
                            <h3 class="card-title">CHEKC IF THE ACCOUNT IS CORRECT</h3>
                          </div>
                          <div class="card-body">
                            <form action="{{url("depositeMoney")}}" method="POST">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">First Name</span>
                              </div>
                              <input type="text" name="first_name" class="form-control" value="{{$item->firstName}}" >
                            </div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Last Name</span>
                                    </div>
                                    <input type="text" name="last name" class="form-control" value="{{$item->lastName}}" >
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">ID</span>
                                </div>
                                <input type="text" class="form-control" name="id_number" value="{{$item->id}}">
                              </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">New Balane after operation $</span>
                              </div>
                              <input type="number" name="balance" class="form-control" value="{{$money+$item->balance}}" >
                              <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                              </div>
                            </div>
                            <input type="submit"  class="btn btn-primary mb-3" value="make deposite">
                            @csrf
                          </form>
                  

                            
                            <!-- /input-group -->
                  
                            
                            </div>
                            <!-- /input-group -->
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                  
                      </div>
                    </div>
            @endforeach
            
        </div>
    </div>
@endsection