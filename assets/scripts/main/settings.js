var modal = document.getElementById('myModal');
	  
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
			
$(document).ready(function(){
	modal.style.display = "block";
	modal.style.zIndex = "500";	
});	

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
	modal.style.display = "none";
}//span.onclick = function() {

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}//window.onclick = function(event) {
		
		
$('#submitForm').click(function () {
			
	var selectedSY = $('#selectedSY').val();
	var selectedSem = $('#selectedSem').val();
	var selectedGp = $('#selectedGp').val();
	
selectedGp			
	jQuery.ajax({
		url: "updateSessionTerm",
        data: {
			'sY':selectedSY,
            'sem':  selectedSem,
            'gP':  selectedGp,
        },
        type: "POST",
        success:function(data){
			var resultValue = $.parseJSON(data);
			//console.log(data);
				if(resultValue['success'] == 1) {
					location.reload();
					return true;
                } else {
                    return false;
                }
            },
                error:function (){}
	}); //jQuery.ajax({
			
			
}); //$('#submitForm').click(function () {

