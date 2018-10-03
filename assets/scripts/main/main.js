$(document).ready(function(){

    $('a[selectApp]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('selectApp');
        removeDOM();
		
		console.log('debug');
        console.log(pageRef);
        callApp(pageRef, 0);
    });

    $('a[selectSettings]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('selectSettings');
        //removeDOM();
        console.log(pageRef);
        callAppSettings(pageRef, 1);
    });
	
    $('a[selectControl]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('selectControl');
        //removeDOM();
        console.log(pageRef);
        callAppControl(pageRef);
    });	
	
	
    function removeDOM() {
        $('div.side-menu').remove();
        $('div.level1').remove();
        $('div.level2').remove();
        $('div.panel-htop').remove();
        $('div.window-mask').remove();
        $('div.window-shadow').remove();
        $('div.autocomplete-suggestions').remove();
    }

    function callApp(pageRefInput, flag) {
        console.log(pageRefInput);
		
        $.ajax({
            url: pageRefInput,
            type: "GET",
            data: { 'groupSystemID': pageRefInput,
					'flag': flag,
			},
            dataType: "html",
            cache: false,
            success: function(response) {
                console.log('the page was loaded');
				console.log(response);
				
                $('#shower').hide();
                $('#hider').show();

                $('.sidemenu').append(response);
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.sidemenu').html(error);
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }

        });
    }


    function callAppSettings(pageRefInput, flag) {
        console.log(pageRefInput);
		
        $.ajax({
            url: pageRefInput,
            type: "GET",
            data: { 'groupSystemID' : pageRefInput,
					'flag': flag,
			},
            dataType: "html",
            cache: false,
            success: function(response) {
				console.log(response);
                console.log('the page was loaded');
               // $('#hider').show();
			   
                //$('#shower').hide();
                //$('#hider').show();

                //$('.sidemenu').append(response);
			   
			   
               $('.levelonecontent').append(response);
                $('#successMessage').hide();
				
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


    function callAppControl(pageRefInput) {
        console.log(pageRefInput);
        $.ajax({
            url: pageRefInput,
            type: "GET",
            data: 'groupSystemID='+pageRefInput,
            dataType: "html",
            cache: false,
            success: function(response) {
                console.log('the page was loaded');
				console.log(response);
               window.location.href = response;
				
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

