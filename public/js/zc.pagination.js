$(function() {
    $(document).on("click", ".J_zcPaginGo", function(e) {
        e.preventDefault(), e.stopPropagation();
        var href, g = $(this).closest(".J_zcPaginationGroup"),
            t = g.find(".J_zcPaginGotoPage"),
            t2 = g.find(".J_zcGotoPageNo"),
            p = parseInt(t2.val()), m = parseInt(t2.prop('max')), p = (p > m) ? m : p;
        p > 0 && (href = t.data("href") + "&page=" + p, t.data("page-no", p), t.prop("href", href), t[0].click());
    });
    $(document).on("click", ".J_zcGotoPageNo", function(e) {
        e.preventDefault(), e.stopPropagation();
    });
    $(document).on("keyup", ".J_zcGotoPageNo", function(e) {
    	if (e.keyCode === 13) {
    		var g = $(this).closest(".J_zcPaginationGroup")
    		$(g).find('.J_zcPaginGo').click();
    	}
    });
});