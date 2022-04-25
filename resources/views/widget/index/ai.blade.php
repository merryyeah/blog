@foreach($aiList as $aiInfo)
    <div class="tab-1-item mt_5">
        <div class="tab-1-item-img">
            <button type="button" class="btn btn-ng">NG</button>
        </div>
        <div class="tab-1-item-desc">
            <div>
                <span class="tab-1-item-lable">序号：</span>
                <span class="tab-1-item-text">{{$aiInfo->serial_no}}</span>
            </div>
            <div>
                <span class="tab-1-item-lable">时间：</span>
                <span class="tab-1-item-text">{{$aiInfo->time}}</span>
            </div>
            <div>
                <span class="tab-1-item-lable">图片1：</span>
                <span class="tab-1-item-text"><a href="javascript:void(0);" class="J_showPopoverLargeColorImg" data-result='{{json_encode($aiInfo)}}'>查看</a></span>
            </div>
        </div>
    </div>
@endforeach
