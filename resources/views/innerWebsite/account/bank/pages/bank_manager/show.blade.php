@extends('innerWebsite.account.bank.layouts.master')

@section('content')



<div class="card-tools pb-2">
    <h1 class="page-title"> 
        <i class="fa fa-user"></i> Bank Manager &nbsp;

        <a href='{{ url("/bank/bank_managers/$bankManager->id/edit") }}' class="btn btn-sm btn-warning">
            <span class="fa fa-edit"></span>&nbsp;
                Edit
        </a>

        <form action='{{ url("/bank/bank_managers/$bankManager->id") }}' method="POST">
          @method('DELETE')
            <button title="Delete" class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i> Delete
            </button>
          @csrf
	      </form>
          
        <a href="{{ url('/bank/bank_managers') }}" class="btn btn-sm btn-warning">
            <span class="fa fa-list"></span>&nbsp;
            Return to List
        </a>
    </h1>
    </div>
<div class="row">
          <div class="col-12">
            <div class="card">
             
              
              <div class="card-body">

              <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Manager Name</h3>
              </div>
              <div class="panel-body" style="padding-top:0;">
                <p>{{ ucwords( $bankManager->name.' '.$bankManager->father_name ) }}</p>
              </div>
              <hr style="margin:0px;margin-bottom:2px;">
                
              <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Email</h3>
              </div>
              <div class="panel-body" style="padding-top:0;">
                <p>{{ $bankManager->user->email }}</p>
              </div>

              <hr style="margin:0px;margin-bottom:2px;">

              <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Mobile Number</h3>
              </div>
              <div class="panel-body" style="padding-top:0;">
                <p>{{ $bankManager->user->mobile_number }}</p>
              </div>

              <hr style="margin:0px;margin-bottom:2px;">

              <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Bank Branch</h3>
              </div>
              <div class="panel-body" style="padding-top:0;">
                <p>{{ $bankManager->bank_branch }}</p>
              </div>

              <hr style="margin:0px;margin-bottom:2px;">

              <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Avatar</h3>
              </div>
              <div class="panel-body" style="padding-top:0;">
                    <img class="img-responsive" src="/storage/uploads/users_profile_picture/{{ $bankManager->user->avatar }}">
            </div>




              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->




@endsection