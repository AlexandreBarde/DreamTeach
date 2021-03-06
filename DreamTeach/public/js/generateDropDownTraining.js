$(document).ready(function() {
    $("#register_school_name").append($('<option>', {
        value: null,
        text: 'Ecole fréquentée',
        disabled: true
    }));
    $("#register_school_name option:last").attr("selected", "selected");

    $("#register_trainingid").append($('<option>', {
        value: 4,
        text: 'Formation suivie',
        disabled: true
    }));
    $("#register_trainingid option:last").attr("selected", "selected");

    $("#register_school_name").change(function() {
        var selectedSchool = $('#register_school_name').find(":selected").val();
        regenerateTraining(selectedSchool);
    });
});

function regenerateTraining(selectedSchool) {
    var selectedSchool = selectedSchool;
    console.log(selectedSchool);

    $.ajax({
        type: 'POST',

        url: "/",

        data: {
            selectedSchool: selectedSchool
        },

        success : function(code_html, statut){
            $("#register_trainingid option[class=" + selectedSchool + "]").show();
            $("#register_trainingid").val($("#register_trainingid option[class="+selectedSchool+"]").val());
            $("#register_trainingid option[class!=" + selectedSchool + "]").hide();
        }
    });
}