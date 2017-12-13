<div style="position: relative; height: 80px;">
     <select class="easyui-combobox" id="type" name="type" data-options="panelHeight:100" style="height:30px;width:120px;">
         <option value="1">เอกสารเลขที่ ม.อ.</option>
         <option value="2">ลำดับแฟ้ม</option>
      </select>
       &nbsp;
      <input type="text" id="autocomplete"  style="position: absolute; z-index: 2; background: transparent;"/>
      <input type="text" id="autocomplete-ajax-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1;"/>
</div>
     <div id="selction-ajax"></div>


<script type="text/javascript">

var url = 'http://localhost/finance/search/approve_docnumber';


function run_autocomplete(url){
        $('#autocomplete').val('');
        $('#autocomplete').focus(); 
           
        $('#autocomplete').autocomplete({
        serviceUrl: url,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);  
        },
        onHint: function (hint) {
                $('#autocomplete-ajax-x').val(hint);
        },
        onSelect: function (suggestion) {
            $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
        },
         onInvalidateSelection: function() {
                $('#selction-ajax').html('You selected: none');
        }
    });
}


$(function () {


$('#type').combobox({
	onSelect: function(param){
        if(param.value == 1){
           url = 'http://localhost/finance/search/approve_docnumber';
        }
        else{
           url = 'http://localhost/finance/search/approve_filenumber';
        }   
        
        run_autocomplete(url);
	}
});


run_autocomplete(url);

});
</script>
