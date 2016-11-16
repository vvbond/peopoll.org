function progresscheck () {
    // Navigation dots code:
    var qnum = $(this).attr('qnum');
    var ansrs = $("#a2q"+qnum);
    if (ansrs.find("[name^='question']").is(":checked")) {
	$("[navdot="+qnum+"]").addClass("checkedPage");
    }
    else if (ansrs.find("[name^='question']").is(":text")) {
	if( $.isNumeric($(this).val()) ) { 
	    $("[navdot="+qnum+"]").addClass("checkedPage");
	}
	else {
	    $("[navdot="+qnum+"]").removeClass("checkedPage");
	}
    }
    else {
	$("[navdot="+qnum+"]").removeClass("checkedPage");
    }

    // Count number of pages, on which at least one of the questions is answered, i.e.,
    // checked:
    var numDoneQ = 0;
    $("[data-role='main']").each( function()
    {
	if ($(this).find("[name^='question']").is(":checked")) { 
	    numDoneQ++; 
	}
	else if ($(this).find("[name^='question']").is(":text")) {
	    if( $.isNumeric($(this).find("[name^='question']").val()) ) { numDoneQ++; }
	}
    });

    // If number of answered questions equals the total number of questions in the poll,
    // activate the SUBMIT button:
    if (numDoneQ == numOfQs) { 
	$(".submitbtn>a").removeClass("ui-disabled");
	$(".submitbtn>a").addClass("ui-enabled ui-btn-active");
    } else {
	$(".submitbtn>a").removeClass("ui-enabled ui-btn-active");
	$(".submitbtn>a").addClass("ui-disabled");
    };
}

function testik() { alert($.isNumeric("12"));}
