$(document).ready(function() {
    $("#listShow").cPager({
        pageSize: 7,
        pageid: "pager",
        itemClass: "li-item"
    });

    var json = { data: [] };
    for (var i = 1; i <= 350; i++) {
        json.data.push({ name: "Username-000" + i });
    }
    $("#listShow").html(TrimPath.processDOMTemplate("listTemplate", json));
    
    $(this).cPager({
        pageSize: 7,
        pageid: "pager",
        itemClass: "li-item"
    });
    $('li.tz.first').click();
});