@extends('admin.layouts.app')
@section('title', 'Board Members')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Board Members</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Board Members</li>
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
                                <h3 class="card-title">Board Members</h3>
                            </div>
                            <form class="attribute-form" method="post"
                                  action="{{ route('admin.board.update',$board->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="grad">Grad</label>
                                            <div class="form-group">
                                                <select name="grad" id="grad" class="form-control">
                                                    @foreach($users as $user)
                                                        <option
                                                            value="{{ $user->id }}" {{ $board->boardGrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @foreach($board->boardGrad->boardChildren($board->board_id) as $pregrad)
                                            <div class="col-md-6">
                                                <label
                                                    for="pregard_{{ $pregrad->position }}">Pregrad {{ $pregrad->position }}</label>
                                                <div class="form-group">
                                                    <select name="pregrad_{{ $pregrad->position }}"
                                                            id="pregrad_{{ $pregrad->position }}" class="form-control">
                                                        @foreach($users as $user)
                                                            <option
                                                                value="{{ $user->id }}" {{ $pregrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @foreach($pregrad->boardChildren($board->board_id) as $undergrad)
                                                <div class="col-md-3">
                                                    <label for="undergrad_{{ $undergrad->position }}">Undergrad {{ $undergrad->position }}</label>
                                                    <div class="form-group">
                                                        <select name="undergrad_{{ $undergrad->position }}" id="undergrad_{{ $undergrad->position }}"
                                                                class="form-control">
                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->id }}" {{ $undergrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Update Board
                                    </button>
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
