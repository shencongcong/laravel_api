@extends('admin.layouts.admin')

@section('admin-css')
    <link href="{{ asset('asset_admin/assets/plugins/parsley/src/parsley.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
   {{-- <link href="{{ asset('asset_admin/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}" rel="stylesheet" />--}}
@endsection

@section('admin-content')
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li><a href="javascript:;">Form Stuff</a></li>
            <li class="active">Form Validation</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Form Validation <small>header small text goes here...</small></h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Basic Form Validation</h4>
                    </div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body panel-form">
                        <form class="form-horizontal form-bordered" data-parsley-validate="true" enctype="multipart/form-data"  action="{{ url('admin/merchant') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="merchant_name">商户名称 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="merchant_name" placeholder="商户名称" data-parsley-required="true" data-parsley-required-message="请输入商户名称" value="{{ old('name') }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="shop_nums">门店数量 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="number" name="shop_nums" placeholder="门店数量" data-parsley-required="true" data-parsley-required-message="请输入门店数量" data-parsley-type="integer" data-parsley-type-message="输入不合法" />
                                </div>
                            </div>

                           <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="expire">到期时间 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" data-parsley-required="true" data-parsley-required-message="请填写到期时间" type="date" name="expire" placeholder="到期时间" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="public_id">公众号 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#parent_id_error"
                                            data-parsley-required-message="请选择公众号"
                                            name="public_id">
                                        <option value="">-- 请选择 --</option>
                                        @foreach($public as $data)
                                        <option value="{{ $data->id }}">{{ $data->public_name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="parent_id_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="role">商户角色 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#role_parent_id_error"
                                            data-parsley-required-message="请选择公众号"
                                            name="role">
                                        <option value="">-- 请选择 --</option>
                                        @foreach($role as $data)
                                            <option value="{{ $data->id }}">{{ $data->display_name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="role_parent_id_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4">logo  * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" name="logo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="introduce">商户介绍 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="introduce" placeholder="商户介绍" data-parsley-required="true" data-parsley-required-message="请输入商户介绍" value="{{ old('name') }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('asset_admin/assets/plugins/parsley/dist/parsley.js') }}"></script>
    <script src="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
   {{-- <script src="{{ asset('asset_admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>--}}
    <script>
        $('.selectpicker').selectpicker('render');
    </script>
@endsection