$(document).ready(function() {
    var clickedButtonCounter = 0;
    var clickedCard2;
    $("button").click(function (e) {
        clickedButtonCounter++;
        if(clickedButtonCounter == 2) {
            $(this).attr("disabled", true);
            clickedButtonCounter = 0;
            var clickedCard1 = this;
            selectCard(clickedCard1, clickedCard2);
        } else {
            $(this).attr("disabled", true);
            clickedCard2 = this;
        }
    });
});

function selectCard(clickedCard1, clickedCard2) {
    $(clickedCard1).attr("disabled", false);
    $(clickedCard2).attr("disabled", false);
    $.ajax({
        type: 'POST',

        url: "/games/memory",

        data: {
            clickedCard1: clickedCard1.id,
            clickedCard2: clickedCard2.id
        },

        success : function(response){
            alert(response['goodAnswer']);
        }
    });
}