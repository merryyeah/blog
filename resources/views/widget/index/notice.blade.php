@foreach($ngList as $ngInfo)
    <div class="img-item list-item J_showPopoverLargeColorImg" data-result='{{json_encode($ngInfo)}}'>
        <h6 class="img-t">
            <p class="{{$ngInfo->result == 'ok' ? 'ok_text' : 'ng_text'}}">{{$ngInfo->result}}</p>
{{--            <p>{{$ngInfo->time}}</p>--}}
        </h6>
{{--        <img src="{{Config::get('app.api_url')}}{{$ngInfo->image}}">--}}
{{--        <img src="{{Config::get('app.api_url')}}{{$ngInfo->image_result}}">--}}
        <img src="{{URL::asset('images/test.jpg')}}">
        <img src="{{URL::asset('images/test.jpg')}}">
    </div>
@endforeach
