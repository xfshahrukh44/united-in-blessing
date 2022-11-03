@extends('admin.layouts.app')
@section('title', 'Generate New Report')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Generate New Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Generate New Report</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Generate New Report</h3>
                            </div>
                            <form class="report-generating-form" method="get" action="{{ route('admin.report.index') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sent_by">Gift Sent By</label>
                                                <select name="sent_by" id="sent_by" class="form-control">
                                                    <option value="">Please Select User</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ (request()->get('sent_by') == $user->id) ? 'selected' : '' }}>{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="received_by">Gift Received By</label>
                                                <select name="received_by" id="received_by" class="form-control">
                                                    <option value="">Please Select User</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ (request()->get('received_by') == $user->id) ? 'selected' : '' }}>{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="board_id">Board Number</label>
                                                <select name="board_id" id="board_id" class="form-control">
                                                    <option value="">Please Select Board</option>
                                                    @foreach($boards as $board)
                                                        <option value="{{ $board->id }}" {{ (request()->get('board_id') == $board->id) ? 'selected' : '' }}>{{ $board->board_number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Value</label>
                                                <select name="amount" id="amount" class="form-control">
                                                    <option value="">Please Select Value</option>
                                                    <option value="100" {{ (request()->get('amount') == '100') ? 'selected' : '' }}>$100</option>
                                                    <option value="400" {{ (request()->get('amount') == '400') ? 'selected' : '' }}>$400</option>
                                                    <option value="1000" {{ (request()->get('amount') == '1000') ? 'selected' : '' }}>$1000</option>
                                                    <option value="2000" {{ (request()->get('amount') == '2000') ? 'selected' : '' }}>$2000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="date_range">Date Range</label>
                                                <input type="text" name="date_range" id="date_range" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row float-right">
                                        <button type="submit" class="btn btn-outline-primary">Generate Report</button>
                                        <button type="button" class="btn btn-primary ml-3" id="generate-pdf-button">Generate PDF</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Result</h3>
                            </div>
                            <div class="card-body">
                                <table id="gift-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>No</th>
                                        <th>Sent By</th>
                                        <th>Received By</th>
                                        <th>Board Number</th>
                                        <th>Value</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gifts as $key => $gift)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $gift->sender->username }}</td>
                                            <td>{{ $gift->receiver->username }}</td>
                                            <td>{{ $gift->board->board_number }}</td>
                                            <td>{{ $gift->amount }}</td>
                                            <td>{{ $gift->updated_at->format('F d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            // Range Picker
            $('input[name="date_range"]').daterangepicker({
                startDate: moment().startOf('year'),
                endDate: moment(),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    // 'This Year': [moment().startOf('year'), moment()],
                    // 'Last Year': [moment().subtract(1, 'year').add(1,'day'), moment()],
                },
                alwaysShowCalendars: true,
                locale: {
                    format: 'MMM DD, Y',
                }
            });

            // Gift DataTable
            $('#gift-table').DataTable({
                responsive: true,
                processing: true,
                pageLength: 10,
            });

            $('#generate-pdf-button').on('click', function (e){
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.generate-pdf-report') }}',
                    data: $('.report-generating-form').serialize(),
                    success: function (msg){
                        console.log(msg);
                    }
                })
            })
        });
    </script>
@endsection

