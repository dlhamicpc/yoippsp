@extends('sample')

@section('content')
<div class="container">
    <div class="container">
            @if (session()->has('account_error'))
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <strong class="swalDefaultError">there is no customer with this id check your input</strong>
                </div>
            </div>
        @endif
        @if (session()->has('successTransfer'))
            <div class="alert alert-success" role="alert">
                <div class="container">
                    <strong>money success fully transfered</strong>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="row mt-3">
        <div class="container">
        <div class="container">
          <div class="col-md-12">
          <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Transfer</h3>
              </div>
              <div class="card-body">
                <form action="{{url("transfer")}}" method="POST">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                  </div>
                  <input type="text" name="Sender_Name" class="form-control" placeholder="sender...." value="{{old('Sendera_Name')}}">
                </div>
                <p style="color:red">{{$errors->first('Sender_Name')}}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                    </div>
                    <input type="text" name="Reciever_Name" class="form-control" placeholder="reciever..." value="{{old('Reciever_Name')}}">
                </div>
                <p style="color:red">{{$errors->first('Reciever_Name')}}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">ID</span>
                    </div>
                    <input type="text" class="form-control" name="sender_id" placeholder="sender id..." value="{{old('sender_id')}}">
                  </div>
                  <p style="color:red">{{$errors->first('sender_id')}}</p>

                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ID</span>
                    </div>
                    <input type="text" class="form-control" name="reciever_id" placeholder="recier id..." value="{{old('reciever_id')}}">
                </div>
                      <p style="color:red">{{$errors->first('reciever_id')}}</p>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input type="number" name="money" class="form-control" value="{{old('money')}}">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
                <p style="color:red">{{$errors->first('money')}}</p>
                <input type="submit"  class="btn btn-primary mb-3" value="make transfer">
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
      </div>

@endsection