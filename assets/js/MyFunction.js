function formatThaiDate(val,row){  
    var formattedDate = new Date(val);
	var day = formattedDate.getDate();
	var month =  formattedDate.getMonth()+1;
	var year = formattedDate.getFullYear() + 543;
    
    if(month < 10) month = '0' + month;
    if(day < 10) day = '0' + day;
    
    var date = [day, month, year].join('/');
    return date
}  


function ConvertThaiYear(val,row){  
    return parseInt(val) + 543;
}  


function padDigits2(val, row) {
    return Array(Math.max(2 - String(val).length + 1, 0)).join(0) + val;
}

function padDigits3(val, row) {
    return Array(Math.max(3 - String(val).length + 1, 0)).join(0) + val;
}

function padDigits4(val, row) {
    return Array(Math.max(4 - String(val).length + 1, 0)).join(0) + val;
}


function formatCurrency(val,row){     
	if(val == "" || val == null || val == "NULL") return val;
	
	//Split Decimals
    var arrs = val.toString().split("."); 	
	//Split data and reverse
	var revs = arrs[0].split("").reverse().join("");    	
	var len = revs.length;
    var tmp = "";  
    for(i = 0; i < len; i++){		
        if(i >0 && (i%3) == 0){  
            tmp+=","+revs.charAt(i);         
        }else{  
            tmp += revs.charAt(i);
        }  
    }  
	//Split data and reverse back
	tmp = tmp.split("").reverse().join("");	
	//Check Decimals
    if(arrs.length > 1 && arrs[1] != undefined){  
        tmp += "."+ arrs[1];  
    }  
    return tmp;  
} 


function myformatter(date){
            var y = date.getFullYear()+543;
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
}

function myparser(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
}

function isset () {
  // From: http://phpjs.org/functions
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: FremyCompany
  // +   improved by: Onno Marsman
  // +   improved by: Rafał Kukawski
  // *     example 1: isset( undefined, true);
  // *     returns 1: false
  // *     example 2: isset( 'Kevin van Zonneveld' );
  // *     returns 2: true
  var a = arguments,
    l = a.length,
    i = 0,
    undef;

  if (l === 0) {
    throw new Error('Empty isset');
  }

  while (i !== l) {
    if (a[i] === undef || a[i] === null) {
      return false;
    }
    i++;
  }
  return true;
}


function empty(mixed_var) {
    //  discuss at: http://phpjs.org/functions/empty/
    // original by: Philippe Baumann
    //    input by: Onno Marsman
    //    input by: LH
    //    input by: Stoyan Kyosev (http://www.svest.org/)
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Onno Marsman
    // improved by: Francesco
    // improved by: Marc Jansen
    // improved by: Rafal Kukawski
    //   example 1: empty(null);
    //   returns 1: true
    //   example 2: empty(undefined);
    //   returns 2: true
    //   example 3: empty([]);
    //   returns 3: true
    //   example 4: empty({});
    //   returns 4: true
    //   example 5: empty({'aFunc' : function () { alert('humpty'); } });
    //   returns 5: false

    var undef, key, i, len;
    var emptyValues = [undef, null, false, 0, '', '0'];

    for (i = 0, len = emptyValues.length; i < len; i++) {
        if (mixed_var === emptyValues[i]) {
            return true;
        }
    }

    if (typeof mixed_var === 'object') {
        for (key in mixed_var) {
            // TODO: should we check for own properties only?
            //if (mixed_var.hasOwnProperty(key)) {
            return false;
            //}
        }
        return true;
    }

    return false;
}
