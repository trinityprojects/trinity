function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
			var courseCode = $('#courseCode').val();
			var sy = $('#sy').val();

				jQuery.ajax({
					url: 'REGSISTRAR/showCurriculumDetails',
					data: { 'courseCode': courseCode,
							'sy': sy},
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						$('.leveltwocontent').html(response);
				
						console.log("the request is successful for content1!");
					},
								
					error: function(error) {
						console.log('the page was NOT loaded', error);
						$('.leveltwocontent').html(error);
					},
								
					complete: function(xhr, status) {
						console.log("The request is complete!");
					}
				}); //jQuery.ajax({


			
        }
    });
}




