
<div class="materials-estimate" id="autocomple-input">

    <b>
        <?php 
        if($ctr < 10) {
            echo '0' . $ctr; 
        } else {
            echo $ctr; 
        }
        
        ?>) 
    </b>
    <input type="text" autofocus class="qty" id="numeric<?php echo $ctr; ?>" name="quantity[]" size="5" maxlength="5" placeholder="Quantity" onBlur="checkBlankField();"/> 
    <input id="materials<?php echo $ctr; ?>"  type="text" name="materials[]" placeholder="Materials <?php echo $ctr; ?>"  size="70" maxlength="70"  onFocus="hideMaterialsID();">
    <input id="units<?php echo $ctr; ?>"  type="text" name="units[]" placeholder="Units <?php echo $ctr; ?>"  size="5" maxlength="5" onBlur="checkMaterialsID();">
    <input id="ID<?php echo $ctr; ?>"  readonly class="materialsID" type="text" name="materialsID[]" size="5" maxlength="5">

    <a href="#" class="remove_field" id="basic-btn-delete">Remove<?php echo $ctr; ?></a>
    <span  class="set-ref<?php echo $ctr; ?>" >
        <!--<a href="#" class="set_reference" id="basic-btn-add">Set as Reference</a>-->
        <a href="javascript:void(0)" id="basic-btn-add" class="set_reference" onclick="ConfirmSmall.render('Set Material as Reference','material_reference','A')" >Set as Reference</a>
    </span>

    <span class="error-set-ref<?php echo $ctr; ?>">Transaction Error!!!</span>

</div>


<script class="dynamic" id="dynamic<?php echo $ctr; ?>">
        var materialsAutocomplete = new autoComplete({
            selector: '#materials<?php echo $ctr; ?>',

            minChars: 0,
            source: function(term, suggest){
                term = term.toLowerCase();
                var items = <?php echo $items; ?>;
                console.log(items);
                var choices = items;
                var suggestions = [];
                for (i=0;i<choices.length;i++)
                    if (~(choices[i][0]+' '+choices[i][1]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                        suggest(suggestions);
            },
            renderItem: function (item, search){
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                return '<div class="autocomplete-suggestion lista<?php echo $ctr; ?>" data-material="'+item[0]+'" data-units="'+item[1]+'" data-ID="'+item[2]+'">'+item[0].replace(re, "<b>$1</b>")+' ('+item[1]+')</div>';

            },
            onSelect: function(e, term, item){
                console.log('Item "'+item.getAttribute('data-material')+' ('+item.getAttribute('data-units')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
                document.getElementById('materials<?php echo $ctr; ?>').value = item.getAttribute('data-material')+' ('+item.getAttribute('data-units')+')';
                document.getElementById('units<?php echo $ctr; ?>').value = item.getAttribute('data-units');
                document.getElementById('ID<?php echo $ctr; ?>').value = item.getAttribute('data-ID');

            }
        });



$(document).ready(function(){
    $('#numeric<?php echo $ctr; ?>').focus();
    $('[id^=numeric]').keypress(validateNumber);
    $('[id^=materials<?php echo $ctr; ?>]').keypress(validateQuotes);
    $('[id^=units<?php echo $ctr; ?>]').keypress(validateQuotes);

    $('.set-ref<?php echo $ctr; ?>').hide();
    $('.error-set-ref<?php echo $ctr; ?>').hide();


});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
    	return true;
    }
};

function validateQuotes(event) {
    var key = window.event ? event.keyCode : event.which;
    console.log(key);
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key == 39 ) {
        return false;
    } else {
    	return true;
    }
};
      function checkBlankField() {
          console.log($('#numeric<?php echo $ctr; ?>').val());
        if (!$('#numeric<?php echo $ctr; ?>').val())         {
            $('#numeric<?php echo $ctr; ?>').focus();
           return (false);
        }
        return (true);
      }

function checkMaterialsID() {

    console.log($('#ID<?php echo $ctr; ?>').val());
    console.log($('#units<?php echo $ctr; ?>').val());
    if ( (!$('#ID<?php echo $ctr; ?>').val()) && !(!$('#units<?php echo $ctr; ?>').val())  ) {
        $('.set-ref<?php echo $ctr; ?>').show();
    }
}

function hideMaterialsID() {
    $('.set-ref<?php echo $ctr; ?>').hide();
    $('.error-set-ref<?php echo $ctr; ?>').hide();

}

$('.set_reference').on("click", function(e) {
    e.preventDefault();
});

    function CustomConfirmSmall(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-small');
            var dialogbox = document.getElementById('dialogbox-small');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (550 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var materials =  $('#materials<?php echo $ctr; ?>').val();
            var units = $('#units<?php echo $ctr; ?>').val();
          
            dialog = dialog + "<br>";
            dialog = dialog + "<div><div>Materials: <u>" + materials  + "</u></div>";
            dialog = dialog + "<div>Units: <u>" + units + "</u></div></div>";

            document.getElementById('dialogboxhead-small').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody-small').innerHTML = dialog;
            document.getElementById('dialogboxfoot-small').innerHTML = '<button onclick="ConfirmSmall.yes(\''+op+'\',\''+status+'\',\''+materials+'\',\''+units+'\')">Proceed</button> <button onclick="ConfirmSmall.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-small').style.display = "none";
            document.getElementById('dialogoverlay-small').style.display = "none";
        }
        this.yes = function(op,status, materials, units){
            if(op == "material_reference"){
                setReference(materials, units);
            }
            document.getElementById('dialogbox-small').style.display = "none";
            document.getElementById('dialogoverlay-small').style.display = "none";
        }
    }
    var ConfirmSmall = new CustomConfirmSmall();

    function setReference(materials, units) {
        console.log(units);
        console.log(materials);

            jQuery.ajax({
                url: "insertMaterialsTBAMIMS",
                data: {
                    'particulars':materials,
                    'units': units
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    //console.log(data);
                    //console.log(resultValue);
                    if(resultValue['success'] == 1) {
                        $('#ID<?php echo $ctr; ?>').val(resultValue['ID']);
                        $('.set-ref<?php echo $ctr; ?>').hide();
                        $('.error-set-ref<?php echo $ctr; ?>').hide();
                        return true;
                    } else {
                        //console.log(resultValue['message']);
                        $('.error-set-ref<?php echo $ctr; ?>').show();
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({


    }  

</script>
