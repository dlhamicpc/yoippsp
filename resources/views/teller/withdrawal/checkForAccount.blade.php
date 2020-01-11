@extends('sample')

@section('content')

<div class="container">
        <div class="row">
            @foreach ($person as $item)
            <div class="container">
                    <div class="container">
                      <div class="col-md-12">
                      <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">CHEKC IF THE ACCOUNT IS CORRECT</h3>
                          </div>
                          <div class="card-body">
                            <form action="{{url("withdrawalMoney")}}" method="POST">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">First Name</span>
                              </div>
                              <input type="text" name="first_name" class="form-control" value="{{$item->firstName}}">
                            </div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Last Name</span>
                                    </div>
                                    <input type="text" name="last name" class="form-control" value="{{$item->lastName}}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">ID</span>
                                </div>
                                <input type="text" class="form-control" name="id_number" value="{{$item->id}}">
                              </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Balance after withdrawal $</span>
                              </div>
                              <input type="number" name="balance" class="form-control" value="{{$item->balance-$amount}}">
                              <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                              </div>
                            </div>
                            <input type="submit"  class="btn btn-primary mb-3" value="make withdrawal">
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