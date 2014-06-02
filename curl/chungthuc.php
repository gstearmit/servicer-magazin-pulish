<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
  <title>AJAX REST CALL TO PHONEGAP BUILD</title>
<script>
$( document ).ready(function() 
{				
    $.getJSON("https://build.phonegap.com/api/v1/me?auth_token=gstearmitphuca4@gmail.com&callback=?",
    function (data) 
    {
        $.each(data, function(property, value) 
	{
            $('body').append(property + " : " + value + "<br>" );
        });
    });
});
</script>
</head>
<body>	  
</body>
</html>