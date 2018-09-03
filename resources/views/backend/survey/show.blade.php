@extends('backend/layout/layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Khảo sát
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.survey.index') !!}">Khảo sát </a></li>
        <li class="active"> Chi tiết </li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.survey.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{trans('fully.back')}} </a>
            </div>
        </div>
        <br> <br> <br>

        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tên khảo sát</th>
                        <th>Nội dung</th>
                        <th>Lượng vote</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{!! $survey->name !!}</td>
                        <td></td>                  
                        <td></td>
                        <td>{!! $survey->created_at !!}</td>
                        <td>{!! $survey->updated_at !!}</td>
                    </tr>
                    @foreach($surveyDetail as $sd)
                    <tr>
                        <td></td>
                        <td>{!! $sd->name !!}</td>                  
                        <td>{!! $sd->rating !!}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop