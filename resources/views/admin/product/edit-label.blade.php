@extends('admin.layouts.app')
@section('title', 'Product Labels')
@section('page_css')
    <style>
        .preloader {
            z-index: 9999999;
        }

        #editor_container {
            height: 600px;
            width: 100%;
        }

        #editor_container .FIE_canvas-node {
            background-color: #b7b7b7;
        }
    </style>
@endsection
@section('section')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Labels</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Labels</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div id="main_container">
                                    <div class="form-group">
                                        <label>Label Name:</label>
                                        <input type="text" class="form-control" id="label_name" placeholder="Label"
                                               value="{{$label->title}}">
                                    </div>
                                    <div id="editor_container"></div>
                                </div>

                                <form action="{{route('update_label', [request()->id, request()->label_id])}}"
                                      method="post"
                                      id="label_form">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" id="ed_image_data" name="ed_image_data">
                                    <input type="hidden" id="ed_image_json" name="ed_image_json">
                                    <input type="hidden" id="ed_label" name="ed_label">
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

    </div>
@endsection
@section('script')
    <script
        src="https://scaleflex.cloudimg.io/v7/plugins/filerobot-image-editor/latest/filerobot-image-editor.min.js"></script>
    <script>
        $(document).ready(function () {
            let isLabel = false
            const {TABS, TOOLS} = (window.FilerobotImageEditor);
            const config = {
                source: "{{ asset('uploads/labels/'.$label->file_name) }}",
                onBeforeSave: imageFileInfo => {
                    const label = $('#label_name')
                    isLabel = true
                    if (label.val().trim() === "") {
                        isLabel = false
                        alert("Please enter label name!")
                    }
                    return false
                },
                onSave: (editedImageObject, designState) => {
                    if (isLabel) {
                        $('#ed_image_data').val(editedImageObject.imageBase64)
                        $('#ed_image_json').val(JSON.stringify(designState))
                        $('#ed_label').val($('#label_name').val().trim())
                        $('#label_form').submit()
                    }
                },
                loadableDesignState: JSON.parse(@json($label->content)),
                annotationsCommon: {
                    fill: '#000000',
                },
                closeAfterSave: true,
                defaultSavedImageType: 'png',
                observePluginContainerSize: true,
                Text: {text: 'Type...'},
                tabsIds: [TABS.ANNOTATE, TABS.RESIZE], // or ['Adjust', 'Annotate', 'Watermark']
                defaultTabId: TABS.ANNOTATE, // or 'Annotate'
                defaultToolId: TOOLS.TEXT, // or 'Text'
            };

            // Assuming we have a div with id="editor_container"
            const filerobotImageEditor = new FilerobotImageEditor(
                document.querySelector('#editor_container'),
                config,
            );

            filerobotImageEditor.render({
                /*onClose: (closingReason) => {
                    if (isLabel)
                        filerobotImageEditor.terminate();
                },*/
            });
        })
    </script>
@endsection
