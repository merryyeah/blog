@extends('layouts.index')

@section('content')
    <input type="hidden" id="J_refreshSec" value="{{Config::get('app.refresh_sec')}}">
    <input type="hidden" id="J_domainUrl" value="{{Config::get('app.domain_url')}}">
    <div id="app" class="scrollbar">
        <div class="block-left">
            <div class="logo" style="display:none;background-image: url(http://207.246.102.200:81/media/images/7.jpg)"></div>
            <h3 class="img-title pull-left">河北联通AI质检</h3> <span class="pull-right" style="margin-top:8px;color: #00bcd4;font-size: 33px;"><span id="J_systemDate">{{date('Y/n/d H:i:s')}}</span></span>
                <div class="J_centerDiv">
                    @include("widget.index.center")
                </div>

                <div class="img-list J_noticeDiv">
                    @include("widget.index.notice")
                </div>
        </div>
        <div class="block-right">
            <div class="block-r1 J_summaryDiv">
                @include("widget.index.summary")
            </div>
            <div class="block-r2 J_historyList">
                <div class="tab-list">
                    <div class="tab-item active J_chooseTab" data-target="J_tabAi">AI检测</div>
                    <div class="tab-item J_chooseTab" data-target="J_tabHistory">人脸识别</div>
                </div>

                <div class="tab-1 scrollbar J_historyTab J_tabAi">
                    @include("widget.index.ai")
                </div>
                <div class="tab-2 scrollbar J_historyTab J_tabHistory">
                    @include("widget.index.history")
                </div>
            </div>
        </div>
    </div>
@endsection

@include("widget.index.largeImg")
