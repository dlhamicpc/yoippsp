@extends('innerWebsite.account.bank.layouts.master')

@section('content')


<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customers List Via Bank Account Link</h3>

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
                      <th>Account Number</th>
                      <th>Book Number</th>
                      <th>Approved</th>
                      <th>Linked At</th>
                      <th>Last Approved At</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach( $customers as $customer )
                    <tr>
                      <td>{{ ++$counter }}</td>
                      <td>{{ ucwords($customer->full_name) }}</td>
                      <td>{{ $customer->account_number }}</td>
                      <td>{{ $customer->book_number }}</td>
                      <td>{{ $customer->approved }}</td>
                      <td>{{ $customer->created_at }}</td>
                      <td>{{ $customer->updated_at }}</td>
                      
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
				{{ $customers->links() }}
			</div>
		</div>




@endsection