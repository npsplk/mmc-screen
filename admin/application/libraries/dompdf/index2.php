<?php
require_once("dompdf_config.inc.php");

/*$html =
  '<html><body>'.
  '<p>Put your html here, or generate it with your favourite '.
  'templating system.</p>'.
  '</body></html>';*/


$html = <<<EOF

<style>

div.top{
width:600px;
margin:20px auto;


}

div.body{
background-color:#fff;
padding:15px;

}


#wrapper{

background-color:#FFE167;
height:1030px;

}

.top-title{

	font-size:30px;
	background-color:#e49306;
	text-align:center;
	color:#fff;
	margin:0px 0px 0px 0px;
	padding:10px;
font-weight:bold;

	
}
.eve-name{

	font-size:25px;
	text-align:center;
	/* border-bottom: 2px solid red; */
}
.eve-tbl-1{


}
.eve-desc-1{
line-height :25px;
text-align:justify;
}


.eve-desc-2{
line-height :25px;
text-align:justify;

}

.tbl-lable{


}

.tbl-desc{

	font-weight:bold;
}

.eve-person{
font-weight:bold;
}

.eve-footer{
text-align:center;
font-size:20px;
float:bottom;

}
.eve-footer{

}
</style>




	<div id='wrapper' class='wrapper-parent'>



<div class="top">

<p class="top-title">We're Having an Event and You're Invited</p>


<div class="body">

<p class="eve-name">Event Name</p>
<hr/>


<p class="eve-person">Dear xxxxx,</p>

<p class="eve-desc-1">
We're excited be holding our next annual event but we're even more excited to be inviting you along to join us!
Places are limited, but you can guarantee your place in one-click by using our super-easy buttons below.
</p>



<p class="eve-tbl-1">

<table vspace="top" align="center">
<tbody>
<tr><td><span class="tbl-lable">Event Date</span></td> <td>:</td> <td> <span class="tbl-desc">from xxx to xxx</span></td></tr>
<tr><td><span class="tbl-lable">Event Time</span></td> <td>:</td> <td> <span class="tbl-desc">from xx to xx</span></td></tr>
<tr><td><span class="tbl-lable">Place</span></td> <td>:</td> <td> <span class="tbl-desc">xxx</span></td></tr>
<tr><td><span class="tbl-lable">Contact Person</span></td> <td>:</td> <td> <span class="tbl-desc">xxx</span></td></tr>
<tr><td><span class="tbl-lable">Fee</span></td> <td>:</td> <td> <span class="tbl-desc">Rs. xxx</span></td></tr>
</tbody>
</table>
</p>

<br/>

<div class="eve-desc-2">
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
</div>







</div>


<p style="position:fixed; bottom:5%;" class="eve-footer">PwC - Event Management System | web: http://pwc.ems.com/</p>

</div>




	</div>

EOF;


$dompdf = new DOMPDF();

$dompdf->set_paper("A4", "portrait");

$dompdf->load_html($html);
$dompdf->render();




//$dompdf->stream("sample.pdf");

$dompdf->stream('my.pdf',array('Attachment'=>0));

