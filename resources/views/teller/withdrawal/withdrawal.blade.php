@extends('sample')

@section('content')
<div class="container">
        <div class="container">
                @if (session()->has('balanceError'))
                <div class="alert alert-danger" role="alert">
                    <div class="container">
                        <strong class="swalDefaultError">insufficient balance</strong>
                    </div>
                </div>
            @endif
            @if (session()->has('noAccount'))
                <div class="alert alert-danger" role="alert">
                    <div class="container">
                        <strong class="swalDefaultError">there is no customer with this id check your input</strong>
                    </div>
                </div>
            @endif
            @if (session()->has('withSuccess'))
                <div class="alert alert-success" role="alert">
                    <div class="container">
                        <strong class="swalDefaultError">withdrawal successfully ....</strong>
                    </div>
                </div>
            @endif
            
        </div>
</div>

<div class="row mt-3">
  <div class="container">
  <div class="container">
    <div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">WITHDRAWAL FORM</h3>
        </div>
        <div class="card-body">
          <form action="withdrawal" method="POST">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input type="text" name="username" class="form-control" placeholder="Username">
          </div>
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">ID</span>
              </div>
              <input type="text" class="form-control" name="id_number" placeholder="id">
            </div>
            <p style="color:red">{{$errors->first('id_number')}}</p>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">$</span>
            </div>
            <input type="number" name="amount" class="form-control">
            <div class="input-group-append">
              <span class="input-group-text">.00</span>
            </div>
          </div>
          <p style="color:red">{{$errors->first('amount')}}</p>
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
</div>

@endsection