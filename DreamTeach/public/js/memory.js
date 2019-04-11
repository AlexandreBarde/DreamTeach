$(document).ready(function() {
    start();
    var clickedButtonCounter = 0;
    var clickedCard1;
    var clickedCard2;

    $("button").click(function (e) {
        clickedButtonCounter++;
        if(clickedButtonCounter == 2) {
            $(this).attr("disabled", true);
            $(this).text($(this).val());
            clickedButtonCounter = 0;
            clickedCard1 = this;
            selectCard(clickedCard1, clickedCard2);

        } else {
            $(clickedCard1).attr("disabled", false);
            $(clickedCard2).attr("disabled", false);

            $(clickedCard1).text("Card");
            $(clickedCard2).text("Card");

            $(this).attr("disabled", true);
            $(this).text($(this).val());
            clickedCard2 = this;
        }
    });
});

var counter = 0;
var intervalId = null;

function selectCard(clickedCard1, clickedCard2) {
    $.ajax({
        type: 'POST',

        url: "/games/memory",

        data: {
            clickedCard1: clickedCard1.id,
            clickedCard2: clickedCard2.id
        },

        success : function(response){
            if(response['goodAnswer']) {
                $("#" + clickedCard1.id + "").remove();
                $("#" + clickedCard2.id + "").remove();
                if($("button").length / 2 == 0) {
                    $("#founded_word").remove();
                    $.ajax({
                        type: 'POST',

                        url: "/games/memory",

                        data: {
                            counter: counter
                        },

                        success : function(response) {
                            $("#memory").append("<div class=\"alert alert-success\" id=\"founded_word\" role=\"alert\">\n" +
                                "Vous avez gagné ! " + response['message'] + "\n" +
                                "</div>");
                            finish();
                        }
                    });
                } else {
                    if($("#founded_word")) {
                        $("#founded_word").remove();
                        $("#memory").append("<div class=\"alert alert-success\" id=\"founded_word\" role=\"alert\">\n" +
                            "  Bravo ! Vous avez trouvé le mot!\n" +
                            "</div>")
                    } else {
                        $("#memory").append("<div class=\"alert alert-success\" id=\"founded_word\" role=\"alert\">\n" +
                            "  Bravo ! Vous avez trouvé le mot!\n" +
                            "</div>")
                    }
                }
            }
        }
    });

}
function finish() {
    clearInterval(intervalId);
    document.getElementById("bip").innerHTML = "Timer : " + counter;
}
function bip() {
    counter++;
    document.getElementById("bip").innerHTML = "Timer : " + counter;
}
function start(){
    intervalId = setInterval(bip, 1000);
}