@foreach($detectList as $detectInfo)
    <div class="img-item big-imgs J_showPopoverLargeColorImg" data-result='{{json_encode($detectInfo)}}'>
        <h3 class="img-t">
            <p style="font-size: 60px;"  class="{{$detectInfo->result == 'ok' ? 'ok_text' : 'ng_text'}}">{{$detectInfo->result}}</p>
            <p style="font-size:37px;">{{$detectInfo->time}}</p>
        </h3>
{{--        <img src="{{Config::get('app.api_url')}}{{$detectInfo->image}}">--}}
{{--        <img src="{{Config::get('app.api_url')}}{{$detectInfo->image_result}}">--}}
        <img src="{{URL::asset('images/test.jpg')}}">
        <img src="{{URL::asset('images/test.jpg')}}">
    </div>
@endforeach
