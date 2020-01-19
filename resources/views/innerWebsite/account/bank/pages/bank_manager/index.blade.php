@extends('innerWebsite.account.bank.layouts.master')

@section('content')

    <div class="card-tools pb-2">
        <a href="{{ url('/bank/add_new_bank_manager') }}" class="btn btn-success" onclick="closeSideBar(true);">
          Add New Bank Manager
        <i class="fa fa-user-plus fa-fw"></i>
        </a>
    </div>

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bank Managers</h3>
                

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              @php $counter = 0 @endphp
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>
                      <th>Bank Branch</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach( $bankManagers as $manager )
                  
                    <tr>
                      <td>{{ ++$counter }}</td>
                      <td>{{ ucwords( $manager->name.' '.$manager->father_name ) }}</td>
                      <td>{{ $manager->user->email }}</td>
                      <td>{{ $manager->user->mobile_number }}</td>
                      <td>{{ $manager->bank_branch }}</td>
                      <td>
                          <a href='{{ url("/bank/bank_managers/$manager->id") }}' class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>

                          <a href='{{ url("/bank/bank_managers/$manager->id/edit") }}' class="btn btn-sm btn-warning">
                            <span class="fa fa-edit"></span> Edit
                          </a>

                          <form action='{{ url("/bank/bank_managers/$manager->id") }}' method="POST">
                            @method('DELETE')
                              <button title="Delete" class="btn btn-sm btn-danger">
                                  <i class="fa fa-trash"></i> Delete
                              </button>
                            @csrf
                         </form>

                      </td>
                    </tr>

                    

                    @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <div class="row">
			<div class="col-12 d-flex justify-content-center pt-5">
				{{ $bankManagers->links() }}
			</div>
		</div>




@endsection

@if( isset($message) )
<script>
alert("'" + {{ $message }} + "'")
</script>
@endif