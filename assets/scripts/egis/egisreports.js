function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
			var sectionCode = $('#sectionCode').val();
			var studentNumber = $('#fullName').val();
			var sectionCodeNS = sectionCode.split(' ').join('');
			
				jQuery.ajax({
					url: 'EGIS/showClassCardDetails',
					data: { 'sectionCode': sectionCode,
							'sectionCodeNS': sectionCodeNS,
							'studentNumber': studentNumber
					},
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						//$('.leveltwocontent').html(response);
						$('.leveltwocontent').html('<div class="level1"><iframe style="width:100%; height:'+600+'px" src="' + window.location.origin + '/trinity/assets/pdf/' + studentNumber + sectionCodeNS + '.pdf"></iframe></div>')						
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



function submitFormRankingBySection(){
    $('#ff').form('submit',{
        onSubmit:function(){
			var sectionCode = $('#sectionCode').val();
			var sectionCodeNS = sectionCode.split(' ').join('');
			
				jQuery.ajax({
					url: 'EGIS/showRankingBySectionEGIS',
					data: { 
						'sectionCode': sectionCode,
						'sectionCodeNS': sectionCodeNS,
					},
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						//$('.leveltwocontent').html(response);
						$('.leveltwocontent').html('<div class="level1"><iframe style="width:100%; height:'+600+'px" src="' + window.location.origin + '/trinity/assets/pdf/rankingBySection' + sectionCodeNS + '.pdf"></iframe></div>')						
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



function submitFormRankingByYearLevel(){
    $('#ff').form('submit',{
        onSubmit:function(){
			var yearLevel = $('#yearLevel').val();
			
				jQuery.ajax({
					url: 'EGIS/showRankingByYearLevelEGIS',
					data: { 
						'yearLevel': yearLevel,
					},
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						//$('.leveltwocontent').html(response);
						$('.leveltwocontent').html('<div class="level1"><iframe style="width:100%; height:'+600+'px" src="' + window.location.origin + '/trinity/assets/pdf/rankingByYearLevel' + yearLevel + '.pdf"></iframe></div>')						
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

