@extends('innerWebsite.account.bill_payment_provider.layouts.master')

@section('content')


<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Payment Detail</h3>

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
                      <th>Name</th>
                      <th>Mobile Number</th>
                      <th>Payment Identification</th>
                      <th>Amount</th>
                      <th>Payment Status</th>
                      <th>Month</th>
                      <th>Year</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach( $paymentDetail as $payment )
                    <tr>
                      <td>{{ ++$counter }}</td>
                      <td>{{ ucwords( $payment->user->personal_user->full_name) }}</td>
                      <td>{{ $payment->user->mobile_number }}</td>

                      @php
                        $paymentIdentification = App\Models\InnerWebsite\UserBillPaymentLink::find($payment->link_id)->user_payment_identification
                      @endphp
                      <td>{{ $paymentIdentification }}</td>
                      <td>{{ $payment->amount }}</td>
                      <td>{{ $payment->payment_status }}</td>
                      <td>{{ $payment->payment_of_month }}</td>
                      <td>{{ $payment->payment_of_year }}</td>
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
				{{ $paymentDetail->links() }}
			</div>
		</div>




@endsection