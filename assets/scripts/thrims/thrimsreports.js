function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
			var reportFileName = $('#reportsName').val();
			var employeeNumber = $('#fullName').val();
				jQuery.ajax({
					url: 'THRIMS/showReportsDetails',
					data: { 'reportFileName': reportFileName,
							'employeeNumber': employeeNumber},
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						//$('.leveltwocontent').html(response);
						$('.leveltwocontent').html('<div class="level1"><iframe style="width:100%; height:'+600+'px" src="' + window.location.origin + '/trinity/assets/pdf/employee-profile.pdf"></iframe></div>')						
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




