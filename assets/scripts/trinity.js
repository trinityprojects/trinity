$(document).ready(function(){

    $('a[select-app]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('select-app');
        removeDOM();
        callApp(pageRef);
    });

    function removeDOM() {
        $('div.requestMenu').remove();
        $('div.requestForm').remove();
        $('div.combo-p').remove();

    }

    function callApp(pageRefInput) {

        $.ajax({
            url: pageRefInput,
            type: "GET",
            dataType: "html",
            cache: false,
            success: function(response) {
                ///alert(response);
                console.log('the page was loaded');
                $('.content').append(response);
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.content').html(error);
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }

        });
    }



});

