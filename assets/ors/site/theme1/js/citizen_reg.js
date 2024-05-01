$(document).ready(function () {
    // const domain = window.location.origin;
    const domain = "../services/login/logout.html";
    
    var trackAppForm = document.createElement("form");
    trackAppForm.method = "POST";
    trackAppForm.action = domain+"/citizenRegistration.html";
    trackAppForm.target = "iframe_a";

    $('.citizen-iframe').append(trackAppForm);

    trackAppForm.submit();

});