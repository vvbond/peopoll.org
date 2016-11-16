<!DOCTYPE HTML>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script src="funcomm.js"></script>
<link rel="stylesheet" href="poll.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
    <div data-role="page">
        <div data-role="header">
	    <h1 id="q1">Question 1</h1>
        </div>
       <div data-role="navbar">
	    <ul>
		<li><a href="#" class="ui-btn-active">Single</a></li>
		<li><a href="#">T/F</a></li>
		<li><a href="#">Y/N</a></li>
		<li><a href="#">Multi</a></li>
		<li><a href="#">Quanti</a></li>
	    </ul>
	    <!-- <label for="qtypeSingle">S</label> -->
	    <!-- <input type="radio" name="qtype" value="" id="qtypeSingle" checked> -->
	    <!-- <label for="qtypeTF">T/F</label> -->
	    <!-- <input type="radio" name="qtype" value="" id="qtypeTF"> -->
	    <!-- <label for="qtypeYN">Y/N</label> -->
	    <!-- <input type="radio" name="qtype" value="" id="qtypeYN"> -->
	    <!-- <label for="qtypeMulti">M</label> -->
	    <!-- <input type="radio" name="qtype" value="" id="qtypeMulti"> -->
	    <!-- <label for="qtypeQuanti">Q</label> -->
	    <!-- <input type="radio" name="qtype" value="" id="qtypeQuanti"> -->
       </div> 	
        <div data-role="main" class="ui-content">
	    <h3 id="#" style="text-align:center;">Answers:</h3>
	    <ul data-role="listview">
	        <li><input type="text" name="qansr" value placeholder="Answer 1"></li>
	        <li><input type="text" name="qansr" value placeholder="Answer 2"></li>
	    </ul>
        </div>
        <div data-role="footer" style="text-align:center;" data-position="fixed">
	    <div id="navbar" data-role="navbar"> 
	    <ul>
		<li><a href="#q$qnumprev" data-transition="slide" data-direction="reverse" 
		       data-icon="arrow-l" data-iconpos="left"></a></li>
		<li class="submitbtn"><a href="#"     
		    style="padding-bottom: 15px;" 
		    class="ui-disabled">Create Poll</a></li>
		<li><a href="#q$qnumnext" data-transition="slide" 
		       data-icon="arrow-r" data-iconpos="right"></a></li>
	    </ul>
	    </div>
         </div>
        </div>
    </div>    
</body>
