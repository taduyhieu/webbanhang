@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Thông tin người dùng
        <small> | Chi tiết</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.user.index') !!}"><i class="fa fa-user"></i> Thông tin người dùng</a></li>
        <li class="active">Chi tiết</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-12">
        <div class="row">
            @include('flash::message')
            <br>
            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="{!! langRoute('admin.user.index') !!}"
                       class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Quay lại </a>
                </div>
            </div>
            <div class="pull-right">
                <div class="btn-toolbar">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalFormRecharge"> <span class="glyphicon glyphicon-plus"></span>&nbsp;Nạp tiền</button>
                </div>
            </div>

            <!-- Modal nạp tiền -->
            <div class="modal fade" id="modalFormRecharge" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Nạp tiền thông qua cổng thanh toán Ngân Lượng</h2>
                        </div>
                        <form id="user-recharge-form" method="post" action="{{ route('admin.user-recharge.wallet')}}">
                            {!! csrf_field() !!}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Họ tên:</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">Số điện thoại:</label>
                                        <input type="text" maxlength="15" class="form-control" id="phone" name="phone" onkeypress="return AllowNumbersOnly(event)">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="money">Số tiền nạp:</label>
                                        <input type="text" maxlength="15" class="form-control" id="money" name="money" onkeypress="return AllowNumbersOnly(event)" placeholder="VND" value="">
                                    </div>
                                    <div class="pull-right">
                                        <button id="recharge-submit" type="button" style="padding: 8px 15px;
                                                border: 1px solid #fff;
                                                border-radius: 15px;
                                                font-weight: bold;
                                                outline: none;
                                                margin-right: 15px;">Nạp tiền</button>
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <br> <br> <br>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td><strong>Tên đầy đủ</strong></td>
                        <td>{!! $user->full_name !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Số điện thoại</strong></td>
                        <td>{!! $user->mobile !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{!! $user->email !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Số dư tài khoản</strong></td>
                        <td>{!! number_format($user->wallet_money) !!} VND</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>

        <div class="row">
            <label>Bài viết đã đăng</label>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Bài viết</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($paymentsInfo))
                    @foreach($paymentsInfo as $info)
                    <tr>
                        <td>{!! $info->newsRE !!}</td>
                        <td>{!! date('d/m/Y - H:i:s', strtotime($info->created_at)) !!}</td>
                        <td>{!! date('d/m/Y - H:i:s', strtotime($info->updated_at)) !!}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <label>Lịch sử nạp tiền</label>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Phương thức thanh toán</th>
                        <th>Mã hóa đơn</th>
                        <th>Số tiền nạp</th>
                        <th>Ngày nạp</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($rechargeInfo))
                    @foreach($rechargeInfo as $recharge)
                    <tr>
                        <td>
                            @if($recharge->recharge_method == 1)
                            Thanh toán ngay
                            @elseif($recharge->recharge_method == 2)
                            Thanh toán tạm giữ
                            @endif
                        </td>
                        <td>{!! $recharge->order_code !!}</td>
                        <td>{!! number_format($recharge->cost) !!} VND</td>
                        <td>{!! date('d/m/Y - H:i:s', strtotime($recharge->created_at)) !!}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function AllowNumbersOnly(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
        }
    }

    // format number
    $("#money").on('keyup', function () {
        var n = parseInt($(this).val().replace(/\D/g, ''), 10);
        $(this).val(n.toLocaleString());
    });

    // Validate
    $(function () {
        $('#recharge-submit').click(function () {
            if (!$('#name').val()) {
                alert('Chưa nhập họ tên');
                return;
            }
            if (!$('#email').val()) {
                alert('Chưa nhập email');
                return;
            } else {
                var email = $('#email').val();
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!filter.test(email)) {
                    alert('Chưa đúng định dạng email');
                    return;
                }
            }

            if (!$('#phone').val()) {
                alert('Chưa nhập số điện thoại');
                return;
            }
            if (!$('#money').val()) {
                alert('Chưa nhập số tiền cần nạp');
                return;
            }
            $('#user-recharge-form').submit();
        });
    });
</script>
@stop