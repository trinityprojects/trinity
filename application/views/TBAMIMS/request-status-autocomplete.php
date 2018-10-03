
<div class="request-status" id="autocomple-input" style="height: 38px">
	<span id="message-author"><?php echo "(" . $userNumber . ") "; ?></span>
    <input id="requestStatusRemarks"  type="text" name="requestStatusRemarks" placeholder="Request Status Remarks"  size="50">
    <input id="requestStatusRemarksID"  readonly class="requestStatusRemarksID" type="text" name="requestStatusID" size="5">
</div>


<script class="dynamic" id="dynamic">
        var requestStatusAutocomplete = new autoComplete({
            selector: '#requestStatusRemarks',

            minChars: 0,
            source: function(term, suggest){
                term = term.toLowerCase();
                var items = <?php echo $items; ?>;
                console.log(items);
                var choices = items;
                var suggestions = [];
                for (i=0;i<choices.length;i++)
                    if (~(choices[i][0]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                        suggest(suggestions);
            },
            renderItem: function (item, search){
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                return '<div class="autocomplete-suggestion lista" data-request-status="'+item[0]+'" data-ID="'+item[1]+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';

            },
            onSelect: function(e, term, item){
                console.log('Item "'+item.getAttribute('data-request-status')+' ('+item.getAttribute('data-units')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
                document.getElementById('requestStatusRemarks').value = item.getAttribute('data-request-status');
                document.getElementById('requestStatusRemarksID').value = item.getAttribute('data-ID');

            }
        });


</script>
