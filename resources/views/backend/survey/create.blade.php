@extends('backend/layout/layout')
@section('content')
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
{!! HTML::script('assets/js/jquery.slug.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}

<script type="text/javascript">
    var listSurvey = [];
    var i = 0;
    $(function () {
        $('#btn-add-survey-detail').click(function () {
            var survey_text = $('#survey_detail').val();
            if (!survey_text) {
                alert("Chưa nhập dữ liệu");
                return;
            }
            var survey_detail = $('#table-survey-detail tbody');
            if (survey_text) {
                survey_detail.append("<tr id='row-survey-detail" + i + "'>" +
                        "<td id='row-survey-text" + i + "'>" + survey_text + "</td>" +
                        "<td><a id='" + i + "' class='btn_remove'><i class='fa fa-trash' aria-hidden='true' style='font-size: 2rem;'></i></a></td>" +
                        "</tr>");
                listSurvey.push(survey_text);
                $('#list-survey').val(JSON.stringify(listSurvey));
                i++;
            }
        });
        $(document).on('click', '.btn_remove', function () {
            let button_id = $(this).attr("id");
            let textRemove = $("#row-survey-text" + button_id + "").text();
            let index = listSurvey.indexOf(textRemove);
            if (index == -1) {
                return;
            }
            listSurvey.splice(index, 1);
            $('#list-survey').val(JSON.stringify(listSurvey));
            $('#row-survey-detail' + button_id + '').remove();
        });
    });
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Khảo sát <small> | Thêm mới</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/survey') !!}"><i class="fa fa-bookmark"></i> </a> Khảo sát</li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="row">
        {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\SurveyController@store', 'files'=>true)) !!}
        {!! csrf_field() !!}

        <!-- Name -->
        <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
            <label class="control-label" for="name">Tên (*)</label>

            <div class="controls"> {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name',
                'placeholder'=>'Tên khảo sát', 'value'=>Input::old('name'))) !!}
                @if ($errors->first('name')) 
                <span class="help-block">{!! $errors->first('name') !!}</span> 
                @endif
            </div>
        </div>
        <br>
        <input id="list-survey" name="list-survey" value="" type="hidden">

        {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success' )) !!}
        <a href="{!! url(getLang() . '/admin/survey') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
        {!! Form::close() !!}
        <br>
        <div class="row">
            <!--Survey question-->
            <div class="control-group col-md-5 {!! $errors->has('survey_detail') ? 'has-error' : '' !!}">
                <label class="control-label" for="survey_detail">Nhập khảo sát</label>
                <div class="controls"> {!! Form::text('survey_detail', null, array('class'=>'form-control', 'id' => 'survey_detail', 'value'=>Input::old('survey_detail'))) !!}
                </div>
            </div>
            <div class="col-md-1">
                <a class="btn btn-success" id="btn-add-survey-detail" style="margin-top: 24px">Thêm</a>
            </div>
            <div class="col-md-6">
                <table class="table table-striped col-md-5" id="table-survey-detail" style="margin-left: 10px;">
                    <thead>
                        <tr>
                            <th>Khảo sát</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('backend.library.validate_special')
@stop