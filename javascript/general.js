$(document).ready(function() {

    $("form").submit(function(event) {
        var ww = $("input[type='password']").first().val();
        var checkww = $("input[type='password']").last().val();
        if( ww != checkww) {
            alert("Uw wachtwoorden komen niet overeen");
            event.preventDefault();
        }
    });

});

