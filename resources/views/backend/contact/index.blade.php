@extends('backend/layout/layout')
@section('content')

<script type="text/javascript">
    $(document).ready(function () {

        $('#notification').show().delay(4000).fadeOut(700);

            // publish settings
            $(".publish").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/contact/" + id + "/toggle-publish/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
                            $("#publish-image-" + id).attr('src', imagePath);
                        }
                    },
                    error: function () {
                        alert("error");
                    }
                })
            });
        });
    </script>

    <section class="content-header">
        <h1>
            {{ trans('fully.contact_form') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
            <li class="active"> {{ trans('fully.contact_form') }}</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="row">
            @include('flash::message')
            <br>
            <div class="col-sm-12">
                <div class="btn-toolbar"><a href="{!! langRoute('admin.contact.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{{ trans('fully.create') }} </a></div>
            </div>
        </div>
        <br>
        <div class="col-lg-12">
                @if($contacts->count())
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('fully.contact_name') }}</th>
                                <th>{{ trans('fully.address') }}</th>
                                <th>{{ trans('fully.phone') }}</th>
                                <th>{{ trans('fully.email') }}</th>
                                <th>{{ trans('fully.status') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr>
                            <td> {!! link_to_route(getLang(). '.admin.contact.show', $contact->company_name, $contact->id, array( 'class' => 'btn btn-link btn-xs' )) !!}
                            </td>
                            <td>{!! $contact->address !!}</td>
                            <td>{!! $contact->phone_number !!}</td>
                            <td>{!! $contact->email !!}</td>
                            <td><a href="#" id="{!! $contact->id !!}" class="publish">
                                            <img id="publish-image-{!! $contact->id !!}" src="{!!url('/')!!}/assets/images/{!! ($contact->is_published) ? 'publish.png' : 'not_publish.png'  !!}"/>
                                        </a></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                        {{ trans('fully.action') }} <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{!! langRoute('admin.contact.show', array($contact->id)) !!}">
                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{{ trans('fully.show') }}
                                            </a></li>
                                            <li><a href="{!! langRoute('admin.contact.edit', array($contact->id)) !!}">
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;{{ trans('fully.edit') }} </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="{!! URL::route('admin.contact.delete', array($contact->id)) !!}">
                                                <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;{{ trans('fully.delete') }} </a></li>
                                                <li class="divider"></li>                                   
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-danger">{{ trans('fully.not_found') }} </div>
                    @endif </div>
                    <div class="pull-left">
                        <ul class="pagination">
                            {!! $contacts->render() !!}
                        </ul>
                    </div>
                </div>
                @stop