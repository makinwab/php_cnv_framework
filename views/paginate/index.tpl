 <html>
<head>
    {loop}
    <script src="{jquery}" type="text/javascript"></script>
    <script src="{custom}" type="text/javascript"></script>
    <script type="text/javascript">
    {pagination}
    </script>
    <style type="text/css">
    /*ul{
    	list-style-type: none;
    }
    ul li{
    	float: left;
    	margin: 0.5em;
    }*/
    body,td,th {font-family: Georgia, Times New Roman, Times, serif; font-size: 15px;}
    .animation_image {background: #F9FFFF;border: 1px solid #E1FFFF;padding: 10px;width: 500px;margin-right: auto;margin-left: auto;}
    #results{width: 500px;margin-right: auto;margin-left: auto;}
    #results ol{margin: 0px;padding: 0px;}
    #results li{margin-top: 20px;border-top: 1px dotted #E1FFFF;padding-top: 20px;}
    </style>
</head>
<a href="{back}">Back</a>
<a href="{logout}">Logout</a>
<ol id="results">
</ol>

<div class="animation_image" style="display:none" align="center"><img src="{image}"</div>
{/loop}
