@extends('admin.layouts.app')
@section('title', 'Create New Board')
@section('page_css')
    <style>
        .invalid-feedback{
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
                        <h1>Create New Board</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create New Board</li>
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
                                <h3 class="card-title">Create New Board</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('admin.board.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="board_number">Board Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="board_number" id="board_number"
                                                       value="{{ old('board_number') }}" required>
                                                @error('board_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="previous_board_number">Previous Board Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="previous_board_number" id="previous_board_number"
                                                       value="{{ old('previous_board_number') }}">
                                                @error('previous_board_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="amount">Amount ($)</label>
                                            <div class="form-group">
                                                <select name="amount" id="amount" class="form-control" required>
                                                    <option value="">Select Board Amount</option>
                                                    <option value="100">$100</option>
                                                    <option value="400">$400</option>
                                                    <option value="1000">$1000</option>
                                                    <option value="2000">$2000</option>
                                                </select>
                                                @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status">Status</label>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">Select Board Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="retired">Retired</option>
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Create Board</button>
                                    <a href="{{route('admin.boards.index')}}" class="btn btn-warning btn-md">Cancel</a>
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
