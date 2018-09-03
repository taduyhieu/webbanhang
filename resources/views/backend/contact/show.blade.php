@extends('backend/layout/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       {{ trans('fully.contact_form') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.contact.index') !!}">{{ trans('fully.contact_form') }} </a></li>
        <li class="active">{{ trans('fully.contact_form') }} </li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.contact.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{ trans('fully.back') }} </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td><strong>{{ trans('fully.contact_name') }}</strong></td>
                <td>{!! $contact->company_name !!}</td>
            </tr>
            <tr>
                <td><strong>{{ trans('fully.address') }}</strong></td>
                <td>{!! $contact->address !!}</td>
            </tr>   
            <tr>
                <td><strong>{{ trans('fully.phone') }}</strong></td>
                <td>{!! $contact->phone_number !!}</td>
            </tr>
            <tr>
                <td><strong>{{ trans('fully.email') }}</strong></td>
                <td>{!! $contact->email !!}</td>
            </tr>
            <tr>
                <td><strong>Slug</strong></td>
                <td>{!! $contact->slug !!}</td>
            </tr>
            <tr>
                <td><strong>{{ trans('fully.create_at') }}</strong></td>
                <td>{!! $contact->created_at !!}</td>
            </tr>
            <tr>
                <td><strong>{{ trans('fully.update_at') }}</strong></td>
                <td>{!! $contact->updated_at !!}</td>
            </tr>
            <tr>
                <td><strong>Url map</strong></td>
                <td>{!! $contact->url_map !!}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@stop