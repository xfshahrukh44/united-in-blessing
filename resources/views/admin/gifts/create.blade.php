@extends('admin.layouts.app')
@section('title', 'Create New Board')
@section('page_css')
    <style>
        .invalid-feedback {
            display: block;
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
                        <h1>Create Gift</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create Gift</li>
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
                                <h3 class="card-title">Create Gift</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('admin.gift.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="board_number">Board Number</label>
                                            <div class="form-group">
                                                <select name="board_number" id="board_number"
                                                        class="form-control">
                                                    <option value="">Select Board</option>
                                                    @foreach($boards as $board)
                                                        <option
                                                            value="{{ $board->id }}">{{ $board->board_number }}</option>
                                                    @endforeach
                                                </select>
                                                @error('board_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="amount">Amount</label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="amount" id="amount"
                                                       value="{{ old('amount') }}" required>
                                                @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sent_by">Sent By</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="sent_by" id="sent_by"
                                                       value="{{ old('sent_by') }}" required>
                                                @error('sent_by')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sent_to">Sent To</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="sent_to" id="sent_to"
                                                       value="{{ old('sent_to') }}" required>
                                                @error('sent_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Status">Status</label>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">Select Status</option>
                                                    <option value="not_sent">Not Sent</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="accepted">Accepted</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Update Gift
                                    </button>
                                    <a href="{{route('admin.gift.index')}}" class="btn btn-warning btn-md">Cancel</a>
                                </div>
                            </form>
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
        $('select[name=board_number]').change(function (){
            alert($(this).find(':selected').attr('value'));
        })
    </script>
@endsection
