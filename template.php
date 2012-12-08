<?php

if (!empty($this->url)){
$title = " - {$this->url_pref}/{$this->url}";
}

if (!empty($this->url->url)){
$title = " - {$this->url_pref}/{$this->url->url}";
}


?>

<html>
<head>
<title><?php echo $this->app_name . $title; ?></title>



<style type="text/css">
<!--

body { background: white; color: black;}
span.title {text-align: center; font-weight: bolder; font-size: larger}

table.urlinfo {border: 0;}
tr.infohead{text-align: center; font-weight: bolder;}
tr.infodata{text-align: center; font-weight: normal;}
span.toprefererstitle{font-weight: bolder;}

table.topreferers{border:0}
tr.toprefererstitle{text-align: center; font-weight: bolder;}
tr.toprefersdata{text-align: center; font-weight: normal;}

input.inputbox{font-size: normal}
input.button{font-size: smaller}

a:originallink{text-decoration: none}
a:shortlink {text-decoration: none}
a:statslink {text-decoration: none}
-->

</style>
</head>
<body>
<span class="title"><?php echo $this->app_name . $title; ?></span>


<?php echo $this->htmlcontent; ?>


</body>
</html>