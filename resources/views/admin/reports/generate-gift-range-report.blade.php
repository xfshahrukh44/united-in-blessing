@extends('admin.layouts.app')
@section('title', 'Generate New Gift Range Report')
@section('page_css')
    <style>
        .boxes {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .boxes input {
            width: 160px;
            height: 45px;
            padding: 0 1rem;
            border: 1px solid #ccc;
        }

        .slider.slider-horizontal {
            width: 43%;
            display: table;
            margin: 0 0 1rem;
        }
    </style>
@endsection
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Generate New Range Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Generate New Gift Range Report</li>
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
                                <h3 class="card-title">Generate New Gift Range Report</h3>
                            </div>
                            <form class="report-generating-form" method="get"
                                  action="{{ route('admin.gift.range.report') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date_range">Date Range</label>
                                                <input type="text" name="date_range" id="date_range"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gift_range">Gift Range</label>
                                                <input type="text" name="gift_range" id="gift_range"
                                                       class="form-control">
                                                <div class="boxes">
                                                    <input type="text" id="min_gift_range">
                                                    <input type="text" id="max_gift_range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row float-right">
                                        <button type="submit" class="btn btn-outline-primary">Show Data</button>
                                        <button type="button" class="btn btn-primary ml-3" id="generate-pdf-button">
                                            Generate PDF
                                        </button>
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
                                        <th>username</th>
                                        <th>Total Gift Sent</th>
                                        <th>Total Gift Received</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gifts as $key => $gift)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $gift->username }}</td>
                                            <td>$ {{ $gift->sentByGifts->sum('amount') }}</td>
                                            <td>$ {{ $gift->sentToGifts->sum('amount') }}</td>
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
            let slider = '';
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

            $('#generate-pdf-button').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.generate-range-pdf-report') }}',
                    data: $('.report-generating-form').serialize(),
                    success: function (msg) {
                        if (msg['class'] === 'success') {
                            toastr.success(msg['message']);
                        } else {
                            toastr.error(msg['message']);
                        }
                    }
                })
            })

            @php
                if (\Illuminate\Support\Facades\Request::has('gift_range')){
                    $giftRange = explode(',', \Illuminate\Support\Facades\Request::get('gift_range'));
                    $minGiftSum = $giftRange[0];
                    $maxGiftSum = $giftRange[1];
                }
            @endphp
            // bootstrap range slider
            slider = new Slider('#gift_range', {
                min: 0,
                max: 20000,
                value: [{{$minGiftSum ?? 1000}}, {{ $maxGiftSum ?? 15000 }}],
                range: true,
                tooltip: 'show',
            });

            // get slider value
            function getSliderVal() {
                let sliderVal = $('#gift_range').slider().val();
                let sliderValArray = sliderVal.split(',');

                $('#min_gift_range').val(sliderValArray[0]);
                $('#max_gift_range').val(sliderValArray[1]);
            }

            // Initialize slider values on load
            // setInterval(getSliderVal, 1000);
            getSliderVal();

            // change slider values on change
            $('#gift_range').slider().on('change', function () {
                getSliderVal();
            })

            // set entered value to range slider
            $('.boxes input').on('change', function () {
                slider.setValue([parseInt($('#min_gift_range').val()), parseInt($('#max_gift_range').val())]);
            })
        });
    </script>
@endsection

