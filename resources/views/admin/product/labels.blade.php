@extends('admin.layouts.app')
@section('title', 'Product Labels')
@section('page_css')
    <style>
        .preloader {
            z-index: 9999999;
        }

        #main_container {
            display: none;
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
                                        <input type="text" class="form-control" id="label_name" placeholder="Label">
                                    </div>
                                    <div id="editor_container"></div>
                                </div>

                                <button class="btn btn-success" id="add_new_label">Add New Label</button>

                                <hr>
                                <div class="row">
                                    @forelse($labels as $label)
                                        <div class="col-md-2">
                                            <img src="{{asset('uploads/labels/'.$label->file_name)}}"
                                                 class="img-fluid border shadow-sm rounded"
                                                 alt="">
                                            <div class="d-flex align-items-center">
                                                <h4 class="my-2">{{$label->title}}</h4>
                                                <div class="btn-container ml-auto">
                                                    <a class="btn btn-sm btn-success"
                                                       href="{{route("edit_label", ['id' => request()->id, 'label_id' => $label->id])}}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form class="d-inline-block"
                                                          method="post"
                                                          action="{{route("delete_label", ['id' => request()->id, 'label_id' => $label->id])}}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm btn-danger" type="submit">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <h4 class="text-secondary">No labels found!</h4>
                                        </div>
                                    @endforelse

                                </div>

                                <form action="{{route('store_label', request()->id)}}"
                                      method="post"
                                      id="label_form">
                                    @csrf
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
                source: "{{ asset('images/new_page.png') }}",
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
                        $('#main_container').css('display', 'none')
                        $('#ed_image_data').val(editedImageObject.imageBase64)
                        $('#ed_image_json').val(JSON.stringify(designState))
                        $('#ed_label').val($('#label_name').val().trim())
                        $('#label_form').submit()
                    }
                },
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
            /*source={sourceEl}
                            getCurrentImgDataFnRef={getImgRef}
                            onSave={(editedImageObject, designState) => onCustomizeSave(designState)}
                            onBeforeSave={imageFileInfo => false}
                            loadableDesignState={imageData}
                            defaultSavedImageType="png"
                            closeAfterSave={true}
                            onClose={closeImgEditor}
                            observePluginContainerSize={true}
                            height={800}
                            annotationsCommon={
                                fill: '#000000',
                            }
            Text={text: 'Type...'}
            tabsIds={['Annotate', 'Resize']} // or {['Adjust', 'Annotate', 'Watermark']}
            defaultTabId={['Annotate']} // or 'Annotate'
            defaultToolId={'Text'} // or 'Text'*/

            // Assuming we have a div with id="editor_container"
            const filerobotImageEditor = new FilerobotImageEditor(
                document.querySelector('#editor_container'),
                config,
            );

            $('#add_new_label').on('click', function (e) {
                e.preventDefault()
                $('#main_container').css('display', 'inherit')
                filerobotImageEditor.render({
                    onClose: (closingReason) => {
                        if (isLabel)
                            filerobotImageEditor.terminate();
                    },
                });
            })

            /*filerobotImageEditor.render({
                onClose: (closingReason) => {
                    console.log('Closing reason', closingReason);
                    filerobotImageEditor.terminate();
                },
            });*/
        })
    </script>
@endsection
