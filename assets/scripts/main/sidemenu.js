$(document).ready(function(){
    $('#shower').hide();
    $('#hider').show();

    $('div[select-item]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('select-item');
        console.log(pageRef);
        removeDOMForm();
        callItem(pageRef);
    });

    function removeDOMForm() {
        $('div.level1').remove();
        $('div.level2').remove();
        $('div.panel.window.panel-htop').remove();
        $('div.panel.combo-p.panel-htop').remove();
        $('div.window-mask').remove();
        $('div.window-shadow').remove();
        $('div.autocomplete-suggestions').remove();
    }
    
    function callItem(pageRefInput) {

        var parts = pageRefInput.split("/");
        var pageRoutes = parts[0] + "/" + parts[1];
        var systemVar = parts[0];
        var moduleVar = parts[1];
        var paramVar = parts[2];
        var sequenceVar = parts[3];

console.log(pageRefInput);		
        $.ajax({
            url: pageRoutes,
            type: "GET",
            data: {
                'param': paramVar,
                'module': moduleVar,
                'sequence': sequenceVar,
                'system': systemVar
            },
            dataType: "html",
			
			beforeSend:function() {
                $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
            },			
            success: function(response) { 
			console.log(response);
                console.log('the page was loaded');
                //alert(response);
                $('.levelonecontent').html(response);
               // $("div.container").css("margin-left", "255px");
                //$('#sticky-sidebar-demo').
                //$('#sticky-sidebar-demo').hide();
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.levelonecontent').html(error);
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
        });
    }


});

function hider() {
    $('#sticky-sidebar-demo').hide();
    $("div#content").css("margin-left", "15px");
    $('#shower').show();
    $('#hider').hide();


}

function shower() {
    $('#sticky-sidebar-demo').show();
    $("div#content").css("margin-left", "255px");
    $('#shower').hide();
    $('#hider').show();

}

