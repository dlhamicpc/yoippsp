@extends('innerWebsite.account.bill_payment_provider.layouts.master')

@section('content')


<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bill Summary</h3>

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
                      <th>Month</th>
                      <th>Year</th>
                      <th>Total Expected Amount</th>
                      <th>Total Collected Amount</th>
                      <th>Remaining Amount</th>
                      <th>Posted On</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach( $billSummary as $bill )
                  
                  @if( (double)$bill->total_expected_amount > (double)$bill->total_collected_amount )
                    @php  $classStyle = 'text-red'; $sign = '-'  @endphp
                  @else
                    @php $classStyle = 'text-success'; $sign = ''  @endphp
                  @endif
                    <tr>
                      <td>{{ ++$counter }}</td>
                      <td>{{ $bill->payment_of_month }}</td>
                      <td>{{ $bill->payment_of_year }}</td>
                      <td>{{ (double)$bill->total_expected_amount }} Birr</td>
                      <td class="{{ $classStyle }} font-weight-800">{{ (double)$bill->total_collected_amount }} Birr</td>
                      <td class="{{ $classStyle }} font-weight-800">{{ $sign.' '.((double)$bill->total_expected_amount - (double)$bill->total_collected_amount) }} Birr</td>
                      <td>{{ $bill->created_at->format('D-M-Y') }}</td>
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
				{{ $billSummary->links() }}
			</div>
		</div>




@endsection