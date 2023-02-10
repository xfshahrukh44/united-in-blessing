@extends('admin.layouts.app')
@section('title', 'Edit Board')
@section('page_css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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
                        <h1>Edit Board</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Board</li>
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
                                <h3 class="card-title">Edit Board</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('admin.board.update',$board->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="board_number">Board Number</label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="board_number" id="board_number"
                                                       value="{{ $board->board_number }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="previous_board_number">Previous Board Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="previous_board_number" id="previous_board_number"
                                                       value="{{ $board->previous_board_number }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="amount">Amount ($)</label>
                                            <div class="form-group">
                                                <select name="amount" id="amount" class="form-control">
                                                    <option value="">Select Board Amount</option>
                                                    <option value="100" {{ ($board->amount == '100') ? 'selected' : '' }}>$100</option>
                                                    <option value="400" {{ ($board->amount == '400') ? 'selected' : '' }}>$400</option>
                                                    <option value="1000" {{ ($board->amount == '1000') ? 'selected' : '' }}>$1000</option>
                                                    <option value="2000" {{ ($board->amount == '2000') ? 'selected' : '' }}>$2000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status">Status</label>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">Select Board Status</option>
                                                    <option value="active" {{ ($board->status == 'active') ? 'selected' : '' }}>Active</option>
                                                    <option value="retired" {{ ($board->status == 'retired') ? 'selected' : '' }}>Retired</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Update Board</button>
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
