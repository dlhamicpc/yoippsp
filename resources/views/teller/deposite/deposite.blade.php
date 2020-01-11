@extends('sample')

@section('content')

<div class="container">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                <div class="container">
                    <strong class="swalDefaultError">Deposite is seccessfully applied</strong>
                </div>
            </div>
        @endif
        @if (session()->has('invalidId'))
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <strong class="swalDefaultError">There is no customer with this id </strong>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row mt-3">
    
        <div class="container">
        <div class="container">
          <div class="col-md-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">DEPOSITE FORM</h3>
              </div>
              <div class="card-body">
                <form action="{{url("deposite")}}" method="POST">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                  </div>
                  <input type="text" name="username" class="form-control" placeholder="Username" value="{{old('username')}}">
                </div>
                <p style="color:red">{{$errors->first('username')}}</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">ID</span>
                    </div>
                    <input type="text" class="form-control" name="id_number" placeholder="id" value="{{old('id_number')}}">
                  </div>
                  <p style="color:red">{{$errors->first('id_number')}}</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input type="number" name="required_money" class="form-control"  value="{{old('required_money')}}">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
                <p style="color:red">{{$errors->first('required_money')}}</p>
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
@endsection