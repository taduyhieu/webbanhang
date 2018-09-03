
<div class="dien-dan row">
    <div class="col-md-12">
        <div class="row first">
            @if(isset($survey))
            <h4 class="text-center">{!! $survey->name !!}</h4>
            @endif
        </div>
        @if(isset($survey->surveyDetail) && $survey->surveyDetail->count() > 0)
        @foreach($survey->surveyDetail as $key => $detail)
        <div class="row">
            <p>
                <input type="radio" name="survey-radio-voting" id="{!! $detail->id !!}" value="{!! $detail->id !!}" placeholder="">
                <label for="{!! $detail->id !!}"></label>
            </p>
            <p>{!! $detail->name !!}</p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{$detail->percent}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p>{!! number_format($detail->rating) !!} phiếu</p>
        </div>
        @endforeach
        @endif
        <div class="row">
            <button id="submit-survey" type="button">Bỏ phiếu</button>
        </div>
    </div>
</div>
<!--{!! HTML::script('frontend/js/jquery.min.js') !!}-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#submit-survey").bind("click", function (e, that) {

            let valueChecked = $('input[name=survey-radio-voting]:checked').val();
            if (!valueChecked || valueChecked <= 0)
            {
                alert("Bạn chưa chọn khảo sát");
                return;
            }
            e.preventDefault();

            $.ajax({
                type: "get",
                url: "{!! url(getLang() . '/survey/" + valueChecked + "/vote') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    if (response == 1) {
                        alert("Bạn đã bỏ phiếu thành công");
                        location.reload();
                    } else {
                        alert("Đã có lỗi xảy ra. Mời bỏ phiếu lại");
                    }

                },
                error: function () {
                    alert("Đã có lỗi xảy ra. Mời bỏ phiếu lại");
                }
            });
        });
    });

</script>