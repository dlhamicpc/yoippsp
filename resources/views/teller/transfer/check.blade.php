@extends('sample')

@section('content')
<div class="row mt-3">
        <div class="container">
          <div class="col-md-12">
          <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Check from for transfer</h3>
              </div>
              <div class="card-body">
                @foreach ($customer_sender as $sender)

                <form action="{{url("checktransfer")}}" method="POST">
                    @method('PATCH')
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Transfer From @</span>
                  </div>
                  <input type="text" name="Sender_Name" class="form-control" placeholder="sender...." value="{{$sender->firstName.' '.$sender->middleName.' '.$sender->lastName}}">
                </div>
                <p style="color:red">{{$errors->first('Sender_Name')}}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Transfer to @</span>
                    </div>
                    <input type="text" name="Reciever_Name" class="form-control" placeholder="reciever..." value="{{$customer_reciever['0']['firstName'].' '.$customer_reciever['0']['middleName'].' '.$customer_reciever['0']['lastName']}}">
                </div>
                <p style="color:red">{{$errors->first('Reciever_Name')}}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Sender ID</span>
                    </div>
                    <input type="text" class="form-control" name="sender_id" placeholder="sender id..." value="{{$sender->id}}">
                  </div>
                  <p style="color:red">{{$errors->first('sender_id')}}</p>

                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Reciever ID</span>
                    </div>
                    <input type="text" class="form-control" name="reciever_id" placeholder="recier id..." value="{{$customer_reciever['0']['id']}}">
                </div>
                      <p style="color:red">{{$errors->first('reciever_id')}}</p>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input type="number" name="money" class="form-control" value="{{$transferd_money}}">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
                <p style="color:red">{{$errors->first('money')}}</p>
                <input type="submit"  class="btn btn-primary mb-3" value="make transfer">
                @csrf
              </form>

                @endforeach
      
      
                
                <!-- /input-group -->
      
                
                </div>
                <!-- /input-group -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      
          </div>
      </div>
@endsection