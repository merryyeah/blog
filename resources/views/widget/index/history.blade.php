<form name="searchForm" id="J_searchForm">
    {{ csrf_field() }}
    <div  class="search-box">
        <input type="hidden" name="page" value="1" class="J_page">
        <span></span>
        <input type="text" name="startTime" placeholder="开始时间" class="form-control J_datetimePicker w-100"/>
        <input type="text" name="endTime" placeholder="结束时间" class="form-control J_datetimePicker ml_5 w-100"/>
        <span></span>
        <select name="status" class="form-control ml_5 w-50" style="width: 100px;">
            <option value="0">状态</option>
            <option value="NG">NG</option>
            <option value="OK">OK</option>
        </select>
        <button type="button" class="btn btn-sm search ml_5 J_searchBtn">搜索</button>
    </div>
    <div id="J_historyContent">
        @include("widget.index.historyContent")
    </div>
</form>
