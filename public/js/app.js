(function () {
    'use strict';
    window.appName = 'prof-estate';
    $(document).ready(function(){
        $("#search_form").submit(function(event){
            event.preventDefault();
            var obj = {
                country : $("#country_select").val(),
                your_site: $("#your_site").val(),
                competitor_1: $("#competitor_site_1").val(),
                competitor_2: $("#competitor_site_2").val()
            }

        });
    });
})();
