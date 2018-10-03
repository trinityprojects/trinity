$(document).ready(function(){
 
    $('div[select-item]').on('click', function(e){
        e.preventDefault();
        var pageRef = $(this).attr('select-item');
        //alert(pageRef);
        removeDOMForm();
        callItem(pageRef);
 
    });

    function removeDOMForm() {
        $('div.requestForm').remove();
        $('div.combo-p').remove();
    }

    function callItem(pageRefInput) {
        $.ajax({
            url: pageRefInput,
            type: "GET",
            dataType: "html",
            success: function(response) {
                console.log('the page was loaded');
                $('div.requestMenu');
                $('.content1').html(response);
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.content1').html(error);
                
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }

        });
    }


});

