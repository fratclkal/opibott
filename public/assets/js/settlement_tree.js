$(document).ready(function () {

    $('body').click( function (e) {
        if ( e.currentTarget == this ){
            //alert("çalıştı");
        }

        //console.log(e.currentTarget);


    });


    // Base url al bulunduğu dizin neyse.
    var count = 0;
    var base_url = window.location.origin;
    $('[data-toggle="popover"]').popover();

    $(".tooltipwork").click(function () {


        var index = $(".tooltipwork").index(this);

        $(".pop-up-content").remove();


        var weecode = $(".weecodetreee").eq(index).attr("data-content");
        var _token = $("input[name=_token]").val();

        $(".wrapinfo").eq(index).after("<div class='pop-up-content'><div style='text-align: center;'><img width='200px;' src='/assets/load2.gif'></div></div>");

        var position = $(".pop-up-content").offset();

        var screenwidth = $(window).width();

        var realscreen = screenwidth / 2;

        if (realscreen < position.left) {
            $(".pop-up-content").css("left", "-300px");
        }



        $.ajax({
            url: base_url + "/treedata",
            type: "POST",
            data: {weecode: weecode, _token: _token},
            success: function (r) {
                console.log(r);
                $(".pop-up-content").html(r);

            }
        });


        $(".pop-up-content").animate({
            left: "+=10",
        }, 400, function () {
            // Animation complete.
        });
    });

});

function boxClose() {
    $(".pop-up-content").remove();
}
