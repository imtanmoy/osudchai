@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product</h3>
    @include('admin.layouts.errors-and-messages')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$product->name}}</h3>
                </div>
                <div class="box-body">
                    {!! Form::model($product, ['method' => 'PUT','files' => true, 'route' => ['admin.products.update', $product->id]]) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Product Info</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Product Packs</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Attributes</a></li>
                            <li><a href="#tab_5" data-toggle="tab">Stock & Price</a></li>
                            <li><a href="#tab_6" data-toggle="tab">Images</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                @include('admin.products.forms.edit.general')
                            </div>
                            <div class="tab-pane" id="tab_2">
                                @include('admin.products.forms.edit.info')
                            </div>
                            <div class="tab-pane" id="tab_3">
                                @include('admin.products.forms.create-options')
                            </div>
                            <div class="tab-pane" id="tab_4">
                                @include('admin.products.forms.edit.attribute')
                            </div>
                            <div class="tab-pane" id="tab_5">
                                @include('admin.products.forms.edit.stock&price')
                            </div>
                            <div class="tab-pane" id="tab_6">

                            </div>
                        </div>
                    </div>
                    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var pid = "{{$product->id}}";


            var $addAttribute = $('#addAttribute');
            var $attributeTable = $('#attributeTable');


            var genericNameAutoComplete = "{{ route('admin.generic_names.suggest') }}";
            var strengthAutoComplete = "{{ route('admin.strengths.suggest') }}";
            var attributeNameAutocomplete = "{{ route('admin.attributes.suggest') }}";


            $('.select2').select2({
                placeholder: 'Select an option'
            });


            var rowCount = 0;
            $addAttribute.click(function (e) {
                rowCount++;
                e.preventDefault();
                $(
                    '<tr>\n' +
                    '<td><input class="form-control typeahead" name="attribute_name[' + rowCount + ']" placeholder="Attribute Name" id="attribute_name"></td>\n' +
                    '<td><input class="form-control" name="attribute_value[' + rowCount + ']" placeholder="Attribute Value" id="attribute_value"></td>\n' +
                    '<td class="text-center"><input data-id="' + rowCount + '" type="button" id="rowDel" class="btn btn-danger btn-sm" value="Delete"></td>\n' +
                    '</tr>'
                ).appendTo($attributeTable);
            });

            $attributeTable.on("click", "#rowDel", function (e) {
//                console.log(e);
//                console.log($(this).attr("data-id"));
                $(this).parents("td").parent('tr').remove();
            });

            $attributeTable.on('click', "#oldrowDel", function () {
                console.log($(this).attr("data-id"));
                var aid = $(this).attr("data-id");
                $.confirm({
                    title: 'Confirm!',
                    content: 'Delete Attribute',
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '/admin/products/' + pid + '/attributes/' + aid,
                                type: 'DELETE',
                                dataType: 'json',
                                data: {method: '_DELETE', submit: true}
                            }).always(function (data) {
                            }).done(function (data) {
                                console.log(data);
                                noty({
                                    layout: 'bottomCenter',
                                    theme: 'relax',
                                    text: data.message,
                                    type: 'success',
                                    timeout: 2000
                                });
                            });
                        },
                        cancel: function () {

                        }
                    }
                });
            });


            $('input#generic_name').typeahead({
                source: function (query, process) {
                    return $.get(genericNameAutoComplete, {query: query}, function (data) {
                        return process(data);
                    });
                }
            });
            $('input#strength').typeahead({
                source: function (query, process) {
                    return $.get(strengthAutoComplete, {query: query}, function (data) {
                        return process(data);
                    });
                }
            });

            $(document).on('input change keyup paste', '#attribute_name', function () {
                $(this).typeahead({
                    source: function (query, process) {
                        return $.get(attributeNameAutocomplete, {query: query}, function (data) {
                            return process(data);
                        });
                    }
                });
            });

            $('form').submit(function (e) {
                console.log($(this).serializeArray());
                //  console.log($(this).serialize());

                //console.log(this);

                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    type: 'POST',
                    url: '{{url('/admin/products/'.$product->id)}}',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    cache: false,
                    data: formData
                })
                    .done(function (data) {
                        console.log(data);
                        window.location.href = '{{route('admin.products.index')}}';
                    }).fail(function () {
                    alert("error");
                });

                e.preventDefault();
            });
        });
    </script>


@endsection

