/*!
 * jQuery progress3 Bar
 * version: 1.0.0
 * @requires jQuery v1.6 or later
 * Copyright (c) 2013 Ravishanker Kusuma
 * http://hayageek.com/
 */
(function ($) {
    $.fn.progress3bar = function (options) 
    {
        var settings = $.extend({
        width:'300px',
        height:'25px',
        color:'#0ba1b5',
        padding:'0px',
        border:'1px solid #ddd'},options);
        
        //Set css to container
        $(this).css({
        	'width':settings.width,
        	'border':settings.border,
        	'border-radius':'5px',
        	'overflow':'hidden',
        	'display':'inline-block',
        	'padding': settings.padding,
        	'margin':'0px 10px 5px 5px'
        	});
        

        // add progress3 bar to container
        var progress3bar =$("<div></div>");
        progress3bar.css({
        'height':settings.height,
        'text-align': 'right',
        'vertical-align':'middle',
     	'color': '#fff',
		'width': '0px',
		'border-radius': '3px',
		'background-color': settings.color
        });
        
        $(this).append(progress3bar);
        
        this.progress3 = function(value)
        {
        	var width = $(this).width() * value/100;
        	progress3bar.width(width).html(value+"%&nbsp;");
        }
        return this;
    };

}(jQuery));