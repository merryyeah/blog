var JX = window.JX || {};
JX.host = window.location.protocol + '//' + window.location.host;

(function($) {
    var index = function(){}
    index.prototype = {
        acUrl : {
            refreshUrl : JX.host + '/refresh',
            searchHistory : JX.host + '/searchHistory'
        },
        init : function() {
            $('.J_historyList').on('click', '.J_chooseTab', JX.index.changeHistoryTab)
            $('.J_datetimePicker').datetimepicker({'language' : 'zh', 'locale' : moment.locale('zh')});

            $(document).on('click', '.J_showPopoverLargeColorImg', JX.index.showPopoverLargeColorImg);
            // JX.index.refreshData()
            $('.J_tabHistory').on('click', '.J_zcPaginationGroup ul>li>a', function (e) {
                e.preventDefault();
                var pageNo = $(this).data('pageNo');
                JX.index.searchHistory(pageNo)
            });
            JX.index.searchHistory(1)
            $('.J_tabHistory').on('click', '.J_searchBtn', function() {
                JX.index.searchHistory(1)
            })
            setInterval(function () {
                var myDate = new Date();
                $('#J_systemDate').html(myDate.toLocaleString());
            }, 1000)
        },
        searchHistory : function (page) {
            $('.J_page').val(page)
            $.ajax({
                url : JX.index.acUrl.searchHistory,
                method : 'post',
                data : $('#J_searchForm').serialize(),
                dataType : 'json'
            }).always(function() {
            }).done(function(ret){
                $('#J_historyContent').html(ret.historyHtml)
            })
        },
        refreshData : function() {
            var sec = parseInt($('#J_refreshSec').val())
            $.ajax({
                url : JX.index.acUrl.refreshUrl,
                method : 'get',
                data : {},
                dataType : 'json'
            }).always(function() {
            }).done(function(ret){
                $('.J_centerDiv').html(ret.centerHtml)
                $('.J_noticeDiv').html(ret.noticeHtml)
                $('.J_summaryDiv').html(ret.summeryHtml)
                $('.J_tabAi').html(ret.aiHtml)
                setTimeout(JX.index.refreshData, sec * 1000)
            })
        },
        showPopoverLargeColorImg: function() {
            var domainUrl = $('#J_domainUrl').val();
            var result = $(this).data('result');
            var status = result.result;
            var statusClass = status == 'ok' ? 'ok_text' : 'ng_text'

            $('.J_imageDiv').attr('src', domainUrl + result.image)
            $('.J_imageResultDiv').attr('src', domainUrl + result.image_result)
            $('.J_time').html(result.time)

            $('.J_result').html(status).removeClass('ok_text').removeClass('ng_text').addClass(statusClass)
            $('#J_largeImgModal').modal()
        },
        changeHistoryTab : function() {
            var target = $(this).data('target')
            $('.J_chooseTab').removeClass('active')
            $(this).addClass('active')
            $('.J_historyTab').hide();
            $('.' + target).show()
        }
    }
    JX.index = new index();

}(jQuery));

$(function(){
    JX.index.init();
});

