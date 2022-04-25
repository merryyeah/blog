@if (!empty($historyListChunk))
    @foreach($historyListChunk as $index => $historyList)
        <div class="tab-2-item">
        @foreach($historyList as $historyInfo)

            <div class="img-item item-img J_showPopoverLargeColorImg" data-result='{{json_encode($historyInfo)}}'>
                <h6 class="img-t">
                    <p  style='font-size: 12px' class="{{$historyInfo->result == 'ok' ? 'ok_text' : 'ng_text'}}">{{$historyInfo->result}}</p>
    {{--                <p>时间</p>--}}
                </h6>
{{--                <img src="{{Config::get('app.api_url')}}{{$historyInfo->image}}">--}}
{{--                <img src="{{Config::get('app.api_url')}}{{$historyInfo->image_result}}">--}}
                <img src="{{URL::asset('images/test.jpg')}}">
                <img src="{{URL::asset('images/test.jpg')}}">
            </div>

        @endforeach
        </div>
    @endforeach
<div class="pull-right ml_5">
    {!!$pagination->renderLinks()!!}
</div>
@endif
