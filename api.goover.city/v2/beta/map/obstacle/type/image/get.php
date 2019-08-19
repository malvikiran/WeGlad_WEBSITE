<?php
/**
 * Created by PhpStorm.
 * User: Matteo Sipione
 * Date: 27/07/2019
 * Time: 10:24
 */


include_once ("../../../../autoload.php");




header("Content-type: image/svg+xml");

if($_GET["id"]!=-1){
$data=Database::executeFetch("SELECT ImageFile,ImageExt FROM Image WHERE idImage=(SELECT IMAGE_idImage FROM Type where idType=?)", array($_GET["id"]));





    echo base64_decode($data["ImageFile"]);
}else{

  echo "
<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version=\"1.1\" id=\"Layer_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"
	 viewBox=\"0 0 512 512\" style=\"enable-background:new 0 0 512 512;\" xml:space=\"preserve\">
<rect x=\"224\" y=\"152.169\" style=\"fill:#FEC986;\" width=\"248\" height=\"343.998\"/>
<rect x=\"311.995\" y=\"432.172\" style=\"fill:#FFFDFD;\" width=\"71.999\" height=\"64.006\"/>
<rect x=\"408.004\" y=\"152.169\" style=\"fill:#FEB860;\" width=\"64.006\" height=\"343.998\"/>
<rect x=\"391.998\" y=\"464.175\" style=\"fill:#9B4573;\" width=\"80.002\" height=\"32\"/>
<rect x=\"232.003\" y=\"464.175\" style=\"fill:#C8546F;\" width=\"80.002\" height=\"32\"/>
<rect x=\"232.003\" y=\"120.177\" style=\"fill:#9B4573;\" width=\"239.996\" height=\"32\"/>
<g>
	<rect x=\"232.003\" y=\"120.177\" style=\"fill:#C8546F;\" width=\"176.001\" height=\"32\"/>
	<rect x=\"268.003\" y=\"16.175\" style=\"fill:#C8546F;\" width=\"176.001\" height=\"64.006\"/>
</g>
<rect x=\"39.996\" y=\"72.175\" style=\"fill:#9B4573;\" width=\"191.997\" height=\"32\"/>
<rect x=\"39.996\" y=\"72.175\" style=\"fill:#C8546F;\" width=\"136.005\" height=\"32\"/>
<rect x=\"39.996\" y=\"104.17\" style=\"fill:#FEC986;\" width=\"191.997\" height=\"391.998\"/>
<rect x=\"176.001\" y=\"104.17\" style=\"fill:#FEB860;\" width=\"56.003\" height=\"391.998\"/>
<g>
	<rect x=\"68\" y=\"96.303\" style=\"fill:#1D1D1B;\" width=\"136.005\" height=\"15.734\"/>
	<rect x=\"251.996\" y=\"144.302\" style=\"fill:#1D1D1B;\" width=\"191.997\" height=\"15.734\"/>
	<rect x=\"68.134\" y=\"144.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"144.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"144.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"144.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"68.134\" y=\"200.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"200.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"200.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"200.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"68.134\" y=\"256.171\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"256.171\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"256.171\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"256.171\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"68.134\" y=\"312.174\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"312.174\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"312.174\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"312.174\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"68.134\" y=\"368.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"368.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"368.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"368.176\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"68.134\" y=\"424.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"108.135\" y=\"424.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"148.131\" y=\"424.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"188.137\" y=\"424.179\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"260.136\" y=\"192.175\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"300.132\" y=\"192.175\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"340.128\" y=\"192.175\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"380.134\" y=\"192.175\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"420.13\" y=\"192.175\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"260.136\" y=\"248.178\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"300.132\" y=\"248.178\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"340.128\" y=\"248.178\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"380.134\" y=\"248.178\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"420.13\" y=\"248.178\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"260.136\" y=\"304.17\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"300.132\" y=\"304.17\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"340.128\" y=\"304.17\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"380.134\" y=\"304.17\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"420.13\" y=\"304.17\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"260.136\" y=\"360.173\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"300.132\" y=\"360.173\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"340.128\" y=\"360.173\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"380.134\" y=\"360.173\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<rect x=\"420.13\" y=\"360.173\" style=\"fill:#1D1D1B;\" width=\"15.734\" height=\"32\"/>
	<path style=\"fill:#1D1D1B;\" d=\"M475.867,487.958V112.307h-40V88.042h16V8.308H260.134v79.735h15.999v24.266h-40.267v-48H36.133
		v423.65H0v15.734h512v-15.734L475.867,487.958L475.867,487.958z M275.868,24.042h160.266v48.267H275.868V24.042z M291.867,88.042
		h128.266v24.266H291.867V88.042z M220.133,487.958H51.867V80.042h168.266V487.958z M380.133,487.958h-64.266v-47.916h64.266
		V487.958z M460.133,487.958h-64.266v-63.65h-95.734v63.65h-64.266V128.041h224.267V487.958z\"/>
	<rect x=\"244.003\" y=\"456.308\" style=\"fill:#1D1D1B;\" width=\"48\" height=\"15.734\"/>
	<rect x=\"403.997\" y=\"456.308\" style=\"fill:#1D1D1B;\" width=\"47.999\" height=\"15.734\"/>
	<rect x=\"292.003\" y=\"40.307\" style=\"fill:#1D1D1B;\" width=\"128.002\" height=\"15.734\"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
";

}