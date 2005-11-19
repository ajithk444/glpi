<?php
/*
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2005 by the INDEPNET Development Team.
 
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------

 LICENSE

	This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
*/
 
// Based on:
// IRMA, Information Resource-Management and Administration
// Christian Bauer 
// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

include ("_relpos.php");
///// Manage Netdevices /////

function titleNetdevices() {
         // titre
         
         GLOBAL  $lang,$HTMLRel;

          echo "<div align='center'><table border='0'><tr><td>";
          echo "<img src=\"".$HTMLRel."pics/networking.png\" alt='".$lang["networking"][11]."' title='".$lang["networking"][11]."'></td><td><a  class='icon_consol' href=\"networking-add-select.php\"><b>".$lang["networking"][11]."</b></a>";
                echo "</td>";
                echo "<td><a class='icon_consol' href='".$HTMLRel."setup/setup-templates.php?type=".NETWORKING_TYPE."'>".$lang["common"][8]."</a></td>";
                echo "</tr></table></div>";
 
}

function showNetworkingOnglets($target,$withtemplate,$actif){
	global $lang, $HTMLRel;
	
	$template="";
	if(!empty($withtemplate)){
		$template="&amp;withtemplate=$withtemplate";
	}

	echo "<div id='barre_onglets'><ul id='onglet'>";
	echo "<li "; if ($actif=="1"){ echo "class='actif'";} echo  "><a href='$target&amp;onglet=1$template'>".$lang["title"][26]."</a></li>";
	echo "<li "; if ($actif=="4") {echo "class='actif'";} echo "><a href='$target&amp;onglet=4$template'>".$lang["Menu"][26]."</a></li>";
	echo "<li "; if ($actif=="5") {echo "class='actif'";} echo "><a href='$target&amp;onglet=5$template'>".$lang["title"][25]."</a></li>";
	if(empty($withtemplate)){
	echo "<li "; if ($actif=="6") {echo "class='actif'";} echo "><a href='$target&amp;onglet=6$template'>".$lang["title"][28]."</a></li>";
	echo "<li "; if ($actif=="7") {echo "class='actif'";} echo "><a href='$target&amp;onglet=7$template'>".$lang["title"][34]."</a></li>";
	echo "<li class='invisible'>&nbsp;</li>";
	echo "<li "; if ($actif=="-1") {echo "class='actif'";} echo "><a href='$target&amp;onglet=-1$template'>".$lang["title"][29]."</a></li>";
	}
	
	echo "<li class='invisible'>&nbsp;</li>";
	
	if (empty($withtemplate)&&preg_match("/\?ID=([0-9]+)/",$target,$ereg)){
	$ID=$ereg[1];
	$next=getNextItem("glpi_networking",$ID);
	$prev=getPreviousItem("glpi_networking",$ID);
	$cleantarget=preg_replace("/\?ID=([0-9]+)/","",$target);
		if ($prev>0) echo "<li><a href='$cleantarget?ID=$prev'><img src=\"".$HTMLRel."pics/left.png\" alt='".$lang["buttons"][12]."' title='".$lang["buttons"][12]."'></a></li>";
	if ($next>0) echo "<li><a href='$cleantarget?ID=$next'><img src=\"".$HTMLRel."pics/right.png\" alt='".$lang["buttons"][11]."' title='".$lang["buttons"][11]."'></a></li>";
	}

	echo "</ul></div>";
	
}

// Plus utilis�
/*
function searchFormNetworking($field="",$phrasetype= "",$contains="",$sort= "",$deleted= "",$link="") {
	// Netwokirng Search Form
	
	GLOBAL $cfg_install, $cfg_layout, $layout, $lang,$HTMLRel;

	$option["glpi_networking.name"]				= $lang["networking"][0];
	$option["glpi_networking.ID"]				= $lang["networking"][50];
	$option["glpi_dropdown_locations.name"]			= $lang["networking"][1];
	$option["glpi_type_networking.name"]				= $lang["networking"][2];
	$option["glpi_networking.serial"]			= $lang["networking"][6];
	$option["glpi_networking.otherserial"]		= $lang["networking"][7]	;
	$option["glpi_dropdown_firmware.name"]		= $lang["networking"][49]	;
	$option["glpi_networking.comments"]			= $lang["networking"][8];
	$option["glpi_networking.contact"]			= $lang["networking"][3];
	$option["glpi_networking.contact_num"]		= $lang["networking"][4];
	$option["glpi_networking.date_mod"]			= $lang["networking"][9];
	$option["glpi_networking_ports.ifaddr"] = $lang["networking"][14];
	$option["glpi_networking_ports.ifmac"] = $lang["networking"][15];
	$option["glpi_dropdown_netpoint.name"]			= $lang["networking"][51];
	$option["glpi_enterprises.name"]			= $lang["common"][5];
	$option["resptech.name"]			=$lang["common"][10];
	$option=addInfocomOptionFieldsToResearch($option);
	$option=addContractOptionFieldsToResearch($option);

	echo "<form method='get' action=\"".$cfg_install["root"]."/networking/networking-search.php\">";
	echo "<div align='center'><table  width='850' class='tab_cadre'>";
	echo "<tr><th colspan='4'><b>".$lang["search"][0].":</b></th></tr>";
	echo "<tr class='tab_bg_1'>";
	echo "<td align='center'>";

	echo "<table>";
	
	for ($i=0;$i<$_SESSION["glpisearchcount"];$i++){
		echo "<tr><td align='right'>";
		if ($i==0){
			echo "<a href='".$cfg_install["root"]."/computers/computers-search.php?add_search_count=1'><img src=\"".$HTMLRel."pics/plus.png\" alt='+'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($_SESSION["glpisearchcount"]>1)
			echo "<a href='".$cfg_install["root"]."/computers/computers-search.php?delete_search_count=1'><img src=\"".$HTMLRel."pics/moins.png\" alt='-'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if ($i>0) {
			echo "<select name='link[$i]'>";
			
			echo "<option value='AND' ";
			if(is_array($link)&&isset($link[$i]) && $link[$i] == "AND") echo "selected";
			echo ">AND</option>";
			
			echo "<option value='OR' ";
			if(is_array($link)&&isset($link[$i]) && $link[$i] == "OR") echo "selected";
			echo ">OR</option>";		

			echo "<option value='AND NOT' ";
			if(is_array($link)&&isset($link[$i]) && $link[$i] == "AND NOT") echo "selected";
			echo ">AND NOT</option>";		
			
			echo "<option value='OR NOT' ";
			if(is_array($link)&&isset($link[$i]) && $link[$i] == "OR NOT") echo "selected";
			echo ">OR NOT</option>";
			
			echo "</select>";
		}
		
		echo "<input type='text' size='15' name=\"contains[$i]\" value=\"". (is_array($contains)&&isset($contains[$i])?stripslashes($contains[$i]):"" )."\" >";
		echo "&nbsp;";
		echo $lang["search"][10]."&nbsp;";
	
		echo "<select name=\"field[$i]\" size='1'>";
        	echo "<option value='all' ";
		if(is_array($field)&&isset($field[$i]) && $field[$i] == "all") echo "selected";
		echo ">".$lang["search"][7]."</option>";
        	reset($option);
		foreach ($option as $key => $val) {
			echo "<option value=\"".$key."\""; 
			if(is_array($field)&&isset($field[$i]) && $key == $field[$i]) echo "selected";
			echo ">". $val ."</option>\n";
		}
		echo "</select>&nbsp;";

		
		echo "</td></tr>";
	}
	echo "</table>";
	echo "</td><td>";
	
	echo $lang["search"][4];
	echo "&nbsp;<select name='sort' size='1'>";
	reset($option);
	foreach ($option as $key => $val) {
		echo "<option value=\"".$key."\"";
		if($key == $sort) echo "selected";
		echo ">".$val."</option>\n";
	}
	echo "</select>";
	echo "</td><td><input type='checkbox' name='deleted' ".($deleted=='Y'?" checked ":"").">";
	echo "<img src=\"".$HTMLRel."pics/showdeleted.png\" alt='".$lang["common"][3]."' title='".$lang["common"][3]."'>";
	echo "</td><td width='80' align='center' class='tab_bg_2'>";
	echo "<input type='submit' value=\"".$lang["buttons"][0]."\" class='submit'>";
	echo "</td></tr></table></div></form>";
}
*/
// Plus utilis�
/*

function showNetworkingList($target,$username,$field,$phrasetype,$contains,$sort,$order,$start,$deleted,$link) {

	// Lists networking

	GLOBAL $cfg_install, $cfg_layout, $cfg_features, $lang, $HTMLRel;;

	$db = new DB;

	$where ="";

	foreach ($field as $k => $f)
	if ($k<$_SESSION["glpisearchcount"])
	if ($contains[$k]==""){
		if ($k>0) $where.=" ".$link[$k]." ";
		$where.=" ('1'='1') ";
		}
	else {
		if ($k>0) $where.=" ".$link[$k]." ";
		$where.="( ";

		// Build query
		if($f=="all") {
			$fields = $db->list_fields("glpi_networking");
			$columns = $db->num_fields($fields);
		
			for ($i = 0; $i < $columns; $i++) {
				if($i != 0) {
					$where .= " OR ";
				}
				$coco = $db->field_name($fields, $i);

				if($coco == "firmware") {
					$where .= " glpi_dropdown_firmware.name LIKE '%".$contains[$k]."%'";
				}
				elseif($coco == "location") {
					$where .= getRealSearchForTreeItem("glpi_dropdown_locations",$contains[$k]);
				}
				elseif($coco == "FK_glpi_enterprise") {
					$where .= "glpi_enterprises.name LIKE '%".$contains[$k]."%'";
				}
				elseif ($coco=="tech_num"){
					$where .= " resptech.name LIKE '%".$contains[$k]."%'";
				} 
				elseif($coco == "type") {
					$where .= " glpi_type_networking.name LIKE '%".$contains[$k]."%'";
				}
				else {
 	  				$where .= "glpi_networking.".$coco . " LIKE '%".$contains[$k]."%'";
				}
			}
			$where .= " OR glpi_networking_ports.ifaddr LIKE '%".$contains[$k]."%'";
			$where .= " OR glpi_networking_ports.ifmac LIKE '%".$contains[$k]."%'";
			$where .= " OR glpi_dropdown_netpoint.name LIKE '%".$contains[$k]."%'";
			$where .= getInfocomSearchToViewAllRequest($contains[$k]);
			$where .= getContractSearchToViewAllRequest($contains[$k]);
		}
		else {
			if ($f=="glpi_dropdown_locations.name"){
				$where .= getRealSearchForTreeItem("glpi_dropdown_locations",$contains[$k]);
			}		
			else if ($phrasetype == "contains") {
				$where .= "($f LIKE '%".$contains[$k]."%')";
			}
			else {
				$where .= "($f LIKE '".$contains[$k]."')";
			}
		}
	$where.=" )";
	}

	if (!$start) {
		$start = 0;
	}
	if (!$order) {
		$order = "ASC";
	}
	$query = "select DISTINCT glpi_networking.ID from glpi_networking LEFT JOIN glpi_dropdown_locations on glpi_networking.location=glpi_dropdown_locations.ID ";
	$query .= " LEFT JOIN glpi_type_networking on glpi_networking.type = glpi_type_networking.ID ";
	$query .= " LEFT JOIN glpi_dropdown_firmware on glpi_networking.firmware = glpi_dropdown_firmware.ID ";
	$query .= " LEFT JOIN glpi_networking_ports on (glpi_networking.ID = glpi_networking_ports.on_device AND  glpi_networking_ports.device_type='2')";	
	$query .= " LEFT JOIN glpi_dropdown_netpoint on (glpi_dropdown_netpoint.ID = glpi_networking_ports.netpoint)";
	$query.= " LEFT JOIN glpi_enterprises ON (glpi_enterprises.ID = glpi_networking.FK_glpi_enterprise ) ";
	$query.= " LEFT JOIN glpi_users as resptech ON (resptech.ID = glpi_networking.tech_num ) ";
	$query.= getInfocomSearchToRequest("glpi_networking",NETWORKING_TYPE);
	$query.= getContractSearchToRequest("glpi_networking",NETWORKING_TYPE);
	$query.= " where ";
	if (!empty($where)) $query .= " $where AND ";
	$query .= " glpi_networking.deleted='$deleted' AND glpi_networking.is_template = '0'  ORDER BY $sort $order";

	// Get it from database	
	if ($result = $db->query($query)) {
		$numrows = $db->numrows($result);

		// Limit the result, if no limit applies, use prior result
		if ($numrows>$cfg_features["list_limit"]) {
			$query_limit = $query ." LIMIT $start,".$cfg_features["list_limit"]." ";
			$result_limit = $db->query($query_limit);
			$numrows_limit = $db->numrows($result_limit);

		} else {
			$numrows_limit = $numrows;
			$result_limit = $result;
		}


		if ($numrows_limit>0) {
			// Pager
			$parameters="sort=$sort&amp;order=$order".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains);
			printPager($start,$numrows,$target,$parameters);

			// Produce headline
			echo "<div align='center'><table class='tab_cadre'><tr>";

			// Name
			echo "<th>";
			if ($sort=="glpi_networking.name") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_networking.name&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["networking"][0]."</a></th>";

			// State		
			echo "<th>".$lang["state"][0]."</th>";
			
			// Manufacturer		
			echo "<th>";
			if ($sort=="glpi_enterprises.name") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_enterprises.name&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["common"][5]."</a></th>";
			
			// Location			
			echo "<th>";
			if ($sort=="glpi_dropdown_locations.completename") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_dropdown_locations.completename&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["networking"][1]."</a></th>";

			// Type
			echo "<th>";
			if ($sort=="glpi_type_networking.name") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_type_networking.name&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["networking"][2]."</a></th>";

			
			// Firmware
			echo "<th>";
			if ($sort=="glpi_dropdown_firmware.name") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_dropdown_firmware.name&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["networking"][49]."</a></th>";

			
			
			// Last modified		
			echo "<th>";
			if ($sort=="glpi_networking.date_mod") {
				if ($order=="DESC") echo "<img src=\"".$HTMLRel."pics/puce-down.png\" alt='' title=''>";
				else echo "<img src=\"".$HTMLRel."pics/puce-up.png\" alt='' title=''>";
			}
			echo "<a href=\"$target?sort=glpi_networking.date_mod&amp;order=".($order=="ASC"?"DESC":"ASC")."&amp;start=$start".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains)."\">";
			echo $lang["networking"][9]."</a></th>";
	
			echo "</tr>";

			for ($i=0; $i < $numrows_limit; $i++) {
				$ID = $db->result($result_limit, $i, "ID");
				$networking = new Netdevice;
				$networking->getfromDB($ID);
				$state=new StateItem;
				$state->getfromDB(NETWORKING_TYPE,$ID);
				
				echo "<tr class='tab_bg_2'>";
				echo "<td><b>";
				echo "<a href=\"".$cfg_install["root"]."/networking/networking-info-form.php?ID=$ID\">";
				echo $networking->fields["name"]." (".$networking->fields["ID"].")";
				echo "</a></b></td>";
				echo "<td>".getDropdownName("glpi_dropdown_state",$state->fields["state"])."</td>";
				echo "<td>". getDropdownName("glpi_enterprises",$networking->fields["FK_glpi_enterprise"]) ."</td>";
				echo "<td>". getDropdownName("glpi_dropdown_locations",$networking->fields["location"]) ."</td>";
				echo "<td>". getDropdownName("glpi_type_networking",$networking->fields["type"]) ."</td>";
				echo "<td>". getDropdownName("glpi_dropdown_firmware",$networking->fields["firmware"]) ."</td>";
				echo "<td>".$networking->fields["date_mod"]."</td>";
				echo "</tr>";
			}

			// Close Table
			echo "</table></div>";

			// Pager
			echo "<br>";
			//$parameters="sort=$sort&amp;order=$order".getMultiSearchItemForLink("field",$field).getMultiSearchItemForLink("link",$link).getMultiSearchItemForLink("contains",$contains);
			printPager($start,$numrows,$target,$parameters);

		} else {
			echo "<div align='center'><b>".$lang["networking"][38]."</b></div>";
			
		}
	}
}
*/



function showNetworkingForm ($target,$ID,$withtemplate='') {
	// Show device or blank form
	
	GLOBAL $cfg_layout,$cfg_install, $lang,$HTMLRel;

	$netdev = new Netdevice;

	$netdev_spotted = false;

	if(empty($ID) && $withtemplate == 1) {
		if($netdev->getEmpty()) $netdev_spotted = true;
	} else {
		if($netdev->getfromDB($ID)) $netdev_spotted = true;
	}

	if($netdev_spotted) {
		if(!empty($withtemplate) && $withtemplate == 2) {
			$template = "newcomp";
			$datestring = $lang["computers"][14].": ";
			$date = date("Y-m-d H:i:s");
		} elseif(!empty($withtemplate) && $withtemplate == 1) { 
			$template = "newtemplate";
			$datestring = $lang["computers"][14].": ";
			$date = date("Y-m-d H:i:s");
		} else {
			$datestring = $lang["computers"][11].": ";
			$date = $netdev->fields["date_mod"];
			$template = false;
		}


	echo "<div align='center'><form name='form' method='post' action=\"$target\">\n";

		if(strcmp($template,"newtemplate") === 0) {
			echo "<input type=\"hidden\" name=\"is_template\" value=\"1\" />\n";
		}

	echo "<table width='800' class='tab_cadre' cellpadding='2'>\n";

		echo "<tr><th align='center' >\n";
		if(!$template) {
			echo $lang["networking"][54].": ".$netdev->fields["ID"];
		}elseif (strcmp($template,"newcomp") === 0) {
			echo $lang["networking"][53].": ".$netdev->fields["tplname"];
		}elseif (strcmp($template,"newtemplate") === 0) {
			echo $lang["common"][6].": <input type='text' name='tplname' value=\"".$netdev->fields["tplname"]."\" size='20'>\n";
		}
		echo "</th><th  align='center'>".$datestring.$date;
		echo "</th></tr>\n";

	
	echo "<tr><td class='tab_bg_1' valign='top'>\n";

	echo "<table cellpadding='1' cellspacing='0' border='0'>\n";

	echo "<tr><td>".$lang["networking"][0].":	</td>\n";
	echo "<td><input type='text' name='name' value=\"".$netdev->fields["name"]."\" size='20'></td>\n";
	echo "</tr>\n";

	echo "<tr><td>".$lang["networking"][1].": 	</td><td>\n";
		dropdownValue("glpi_dropdown_locations", "location", $netdev->fields["location"]);
	echo "</td></tr>\n";
	
	echo "<tr class='tab_bg_1'><td>".$lang["common"][10].": 	</td><td colspan='2'>\n";
		dropdownUsersID("tech_num", $netdev->fields["tech_num"]);
	echo "</td></tr>\n";
		
	echo "<tr><td>".$lang["networking"][4].":	</td>\n";
	echo "<td><input type='text' name='contact_num' value=\"".$netdev->fields["contact_num"]."\" size='20'></td>";
	echo "</tr>\n";

	echo "<tr><td>".$lang["networking"][3].":	</td>\n";
	echo "<td><input type='text' name='contact' size='20' value=\"".$netdev->fields["contact"]."\"></td>";
	echo "</tr>\n";
	
	if (!$template){
	echo "<tr><td>".$lang["reservation"][24].":</td><td><b>";
	showReservationForm(NETWORKING_TYPE,$ID);
	echo "</b></td></tr>";
	}

		
		echo "<tr><td>".$lang["state"][0].":</td><td>\n";
		$si=new StateItem();
		$t=0;
		if ($template) $t=1;
		$si->getfromDB(NETWORKING_TYPE,$netdev->fields["ID"],$t);
		dropdownValue("glpi_dropdown_state", "state",$si->fields["state"]);
		echo "</td></tr>\n";
		
	echo "<tr><td>".$lang["setup"][88].": 	</td><td>\n";
		dropdownValue("glpi_dropdown_network", "network", $netdev->fields["network"]);
	echo "</td></tr>\n";

	echo "<tr><td>".$lang["setup"][89].": 	</td><td>\n";
		dropdownValue("glpi_dropdown_domain", "domain", $netdev->fields["domain"]);
	echo "</td></tr>\n";

	echo "</table>\n";

	echo "</td>\n";	
	echo "<td class='tab_bg_1' valign='top'>\n";

	echo "<table cellpadding='1' cellspacing='0' border='0'>\n";

	echo "<tr><td>".$lang["networking"][2].": 	</td><td>\n";
		dropdownValue("glpi_type_networking", "type", $netdev->fields["type"]);
	echo "</td></tr>\n";
	
	echo "<tr class='tab_bg_1'><td>".$lang["common"][5].": 	</td><td colspan='2'>\n";
		dropdownValue("glpi_enterprises","FK_glpi_enterprise",$netdev->fields["FK_glpi_enterprise"]);
	echo "</td></tr>\n";
	
	echo "<tr><td>".$lang["networking"][49].": 	</td><td>\n";
	dropdownValue("glpi_dropdown_firmware", "firmware", $netdev->fields["firmware"]);
	echo "</td></tr>\n";
		
	echo "<tr><td>".$lang["networking"][5].":	</td>\n";
	echo "<td><input type='text' name='ram' value=\"".$netdev->fields["ram"]."\" size='10'></td>";
	echo "</tr>\n";

	echo "<tr><td>".$lang["networking"][6].":	</td>\n";
	echo "<td><input type='text' name='serial' size='20' value=\"".$netdev->fields["serial"]."\"></td>";
	echo "</tr>\n";

	echo "<tr><td>".$lang["networking"][7].":</td>\n";
	echo "<td><input type='text' size='20' name='otherserial' value=\"".$netdev->fields["otherserial"]."\"></td>";
	echo "</tr>\n";
	
	echo "<tr><td>".$lang["networking"][14].":</td>\n";
	echo "<td><input type='text' size='20' name='ifaddr' value=\"".$netdev->fields["ifaddr"]."\"></td>";
	echo "</tr>\n";

	echo "<tr><td>".$lang["networking"][15].":</td>\n";
	echo "<td><input type='text' size='20' name='ifmac' value=\"".$netdev->fields["ifmac"]."\"></td>";
	echo "</tr>\n";
		
	echo "</table>\n";
	
	echo "</td>\n";	
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td class='tab_bg_1' valign='top' colspan='2'>\n";

	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td valign='top'>\n";
	echo $lang["networking"][8].":	</td>\n";
	echo "<td align='center'><textarea cols='35' rows='4' name='comments' >".$netdev->fields["comments"]."</textarea>\n";
	echo "</td></tr></table>\n";

	echo "</td>";
	echo "</tr>\n";

	echo "<tr>\n";
	
	if ($template) {

			if (empty($ID)||$withtemplate==2){
			echo "<td class='tab_bg_2' align='center' colspan='2'>\n";
			echo "<input type='hidden' name='ID' value=$ID>";
			echo "<input type='submit' name='add' value=\"".$lang["buttons"][8]."\" class='submit'>";
			echo "</td>\n";
			} else {
			echo "<td class='tab_bg_2' align='center' colspan='2'>\n";
			echo "<input type='hidden' name='ID' value=$ID>";
			echo "<input type='submit' name='update' value=\"".$lang["buttons"][7]."\" class='submit'>";
			echo "</td>\n";
			}

	} else {

		echo "<td class='tab_bg_2' valign='top'>";
		echo "<input type='hidden' name='ID' value=\"$ID\">\n";
		echo "<div align='center'><input type='submit' name='update' value=\"".$lang["buttons"][7]."\" class='submit'></div>";
//		echo "</form></td>\n\n";
		echo "<td class='tab_bg_2' valign='top'>\n";
//		echo "<form action=\"$target\" method='post'>\n";

//		echo "<input type='hidden' name='ID' value=\"$ID\">\n";
		echo "<div align='center'>\n";
		if ($netdev->fields["deleted"]=='N')
		echo "<input type='submit' name='delete' value=\"".$lang["buttons"][6]."\" class='submit'>\n";
		else {
		echo "<input type='submit' name='restore' value=\"".$lang["buttons"][21]."\" class='submit'>\n";
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='purge' value=\"".$lang["buttons"][22]."\" class='submit'>\n";
		}
		echo "</div>\n";
		echo "</td>\n";
	}
		echo "</tr>\n";

		echo "</table></form></div>\n";

	return true;
		}
	else {
                echo "<div align='center'><b>".$lang["networking"][38]."</b></div>";
                return false;
        }

}

function addNetdevice($input) {
	// Add Netdevice, nasty hack until we get PHP4-array-functions
	$db=new DB;
	$netdev = new Netdevice;

	// dump the status
	$oldID=$input["ID"];

	unset($input['add']);
	unset($input['withtemplate']);
	unset($input['ID']);
	
	// Manage state
	$state=$input["state"];
	unset($input["state"]);

 	// set new date.
 	$netdev->fields["date_mod"] = date("Y-m-d H:i:s");
	
	// fill array for update
	foreach ($input as $key => $val) {
		if (empty($netdev->fields[$key]) || $netdev->fields[$key]  != $input[$key]) {
			$netdev->fields[$key] = $input[$key];
		}
	}

	$newID=$netdev->addToDB();
	
	// Add state
	if (isset($input["is_template"])&&$input["is_template"]==1)
	updateState(NETWORKING_TYPE,$newID,$state,1);
	else updateState(NETWORKING_TYPE,$newID,$state);
	
	// ADD Infocoms
	$ic= new Infocom();
	if ($ic->getFromDB(NETWORKING_TYPE,$oldID)){
		$ic->fields["FK_device"]=$newID;
		unset ($ic->fields["ID"]);
		$ic->addToDB();
	}
	
		// ADD Ports
	$query="SELECT ID from glpi_networking_ports WHERE on_device='$oldID' AND device_type='".NETWORKING_TYPE."';";
	$result=$db->query($query);
	if ($db->numrows($result)>0){
		
		while ($data=$db->fetch_array($result)){
			$np= new Netport();
			$np->getFromDB($data["ID"]);
			unset($np->fields["ID"]);
			unset($np->fields["ifaddr"]);
			unset($np->fields["ifmac"]);
			unset($np->fields["netpoint"]);
			$np->fields["on_device"]=$newID;
			$np->addToDB();
			}
	}

	// ADD Contract				
	$query="SELECT FK_contract from glpi_contract_device WHERE FK_device='$oldID' AND device_type='".NETWORKING_TYPE."';";
	$result=$db->query($query);
	if ($db->numrows($result)>0){
		
		while ($data=$db->fetch_array($result))
			addDeviceContract($data["FK_contract"],NETWORKING_TYPE,$newID);
	}
	
	// ADD Documents			
	$query="SELECT FK_doc from glpi_doc_device WHERE FK_device='$oldID' AND device_type='".NETWORKING_TYPE."';";
	$result=$db->query($query);
	if ($db->numrows($result)>0){
		
		while ($data=$db->fetch_array($result))
			addDeviceDocument($data["FK_doc"],NETWORKING_TYPE,$newID);
	}

	return $newID;
	
}

function updateNetdevice($input) {
	// Update a netdevice in the database

	$netdev = new Netdevice;
	$netdev->getFromDB($input["ID"]);

	// set new date and make sure it gets updated
	$updates[0]= "date_mod";
	$netdev->fields["date_mod"] = date("Y-m-d H:i:s");

	// Get all flags and fill with 0 if unchecked in form
	foreach ($netdev->fields as $key => $val) {
		if (eregi("\.*flag\.*",$key)) {
			if (!$input[$key]) {
				$input[$key]=0;
			}
		}
	}
		
	// Fill the update-array with changes
	$x=1;
	foreach ($input as $key => $val) {
		if (array_key_exists($key,$netdev->fields) && $netdev->fields[$key] != $input[$key]) {
			$netdev->fields[$key] = $input[$key];
			$updates[$x] = $key;
			$x++;
		}
	}
	if (isset($input["is_template"])&&$input["is_template"]==1)
	updateState(NETWORKING_TYPE,$input["ID"],$input["state"],1);
	else updateState(NETWORKING_TYPE,$input["ID"],$input["state"]);

	$netdev->updateInDB($updates);

}

function deleteNetdevice($input,$force=0) {
	// Delete Netdevice
	
	$netdev = new Netdevice;
	$netdev->deleteFromDB($input["ID"],$force);
} 

function restoreNetdevice($input) {
	// Restore Netdevice
	
	$ct = new Netdevice;
	$ct->restoreInDB($input["ID"]);
} 



///// Manage Ports on Devices /////

function showPorts ($device,$device_type,$withtemplate='') {
	
	GLOBAL $cfg_layout,$cfg_install, $lang,$HTMLRel;
	
	$db = new DB;
	switch($device_type) {
		case COMPUTER_TYPE :
			$device_real_table_name = "glpi_computers";
			break;
		case NETWORKING_TYPE :
			$device_real_table_name = "glpi_networking";
			break;
		case PRINTER_TYPE :
			$device_real_table_name = "glpi_printers";
			break;
		case PERIPHERAL_TYPE :
			$device_real_table_name = "glpi_peripherals";
			break;
	}
	$query = "SELECT location from ".$device_real_table_name." where ID = ".$device."";
	$location = $db->result($db->query($query),0,"location");

	$query = "SELECT ID FROM glpi_networking_ports WHERE (on_device = $device AND device_type = $device_type) ORDER BY logical_number";
	if ($result = $db->query($query)) {
		if ($db->numrows($result)!=0) { 
			
			$colspan=8;
			if ($withtemplate!=2){
//			echo "<form method=post action=\"".$cfg_install["root"]."/networking/networking-port.php\">";
//			$colspan=4;
			}
			
			echo "<br><div align='center'><table class='tab_cadre' width='90%'>";
			echo "<tr><th colspan='$colspan'>";
			echo $db->numrows($result)." ";
			if ($db->numrows($result)<2) {
				echo $lang["networking"][37];
			} else {
				echo $lang["networking"][13];
			}
			echo ":</th>";

			if ($withtemplate!=2){
/*				echo "<th  colspan='$colspan'>";
				echo $lang["networking"][55].":&nbsp;";
				dropdown("glpi_dropdown_vlan","vlan");
				echo "<input type='submit' name='assign_vlan' value='".$lang["buttons"][3]."' class='submit'>";
				echo "<a href='".$_SERVER["PHP_SELF"]."?ID=$device&amp;select=all'>".$lang["buttons"][18]."</a>";
				echo "&nbsp;/&nbsp;";
				echo "<a href='".$_SERVER["PHP_SELF"]."?ID=$device&amp;select=none'>".$lang["buttons"][19]."</a>";
				echo "</th>";
*/
			}
			echo "</tr>";        
			echo "<tr><th>#</th><th>".$lang["networking"][0]."</th><th>".$lang["networking"][51]."</th>";
			echo "<th>".$lang["networking"][14]."</th><th>".$lang["networking"][15]."</th>";
			echo "<th>".$lang["networking"][56]."</th>";
			echo "<th>".$lang["networking"][16]."</th><th>".$lang["networking"][17].":</th></tr>\n";
			$i=0;
			while ($devid=$db->fetch_row($result)) {
				$netport = new Netport;
				$netport->getfromDB(current($devid));
				echo "<tr class='tab_bg_1'>";
				echo "<td align='center'><b>";
				if ($withtemplate!=2) echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?ID=".$netport->fields["ID"]."&amp;location=".$location."\">";
				echo $netport->fields["logical_number"];
				if ($withtemplate!=2) echo "</a>";
				echo "</b></td>";
        echo "<td>".$netport->fields["name"]."</td>";
		echo "<td>".getDropdownName("glpi_dropdown_netpoint",$netport->fields["netpoint"])."</td>";
				echo "<td>".$netport->fields["ifaddr"]."</td>";
				echo "<td>".$netport->fields["ifmac"]."</td>";
				// VLANs
				echo "<td>";
					showPortVLAN($netport->fields["ID"],$withtemplate);
				echo "</td>";
				echo "<td>".getDropdownName("glpi_dropdown_iface",$netport->fields["iface"])."</td>";
				echo "<td>";
					showConnection($netport->fields["ID"],$withtemplate,$device_type);
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>\n\n";
			// Assign VLAN form
			if ($withtemplate!=2){
//			echo "</form>";
			}

			
		}
	}
}

function showPortVLAN($ID,$withtemplate,$referer=''){
global $HTMLRel,$lang;
$db=new DB;

echo "<table cellpadding='0' cellspacing='0'>";
/*if ($withtemplate!=2){
	$sel="";
	if (isset($_GET["select"])&&$_GET["select"]=="all") $sel="checked";
		echo "<tr><td colspan='2'><input type='checkbox' name='toassign[$ID]' value='1' $sel></td></tr>";
}
*/
$query="SELECT * from glpi_networking_vlan WHERE FK_port='$ID'";
$result=$db->query($query);
if ($db->numrows($result)>0)
while ($line=$db->fetch_array($result)){
	echo "<tr><td>".getDropdownName("glpi_dropdown_vlan",$line["FK_vlan"]);
	echo "</td><td>";
	echo "<a href='".$HTMLRel."networking/networking-port.php?unassign_vlan=unassigned&amp;ID=".$line["ID"]."&referer=$referer'>";
    echo "<img src=\"".$HTMLRel."/pics/delete2.png\" alt='".$lang["buttons"][6]."' title='".$lang["buttons"][6]."'>";
    echo "</a></td></tr>";
}
echo "</table>";

}

function assignVlan($port,$vlan){
$db=new DB;
$query="INSERT INTO glpi_networking_vlan (FK_port,FK_vlan) VALUES ('$port','$vlan')";
$db->query($query);
}

function unassignVlan($ID){
$db=new DB;
$query="DELETE FROM glpi_networking_vlan WHERE ID='$ID'";
$db->query($query);
}

function showNetportForm($target,$ID,$ondevice,$devtype,$several,$search = '', $location = '') {

	GLOBAL $cfg_install, $cfg_layout, $lang, $REFERER;

	$netport = new Netport;
	if($ID)
	{
		$netport->getFromDB($ID);
		$netport->getDeviceData($netport->fields["on_device"],$netport->fields["device_type"]);
	}
	else
	{
		$netport->getFromNull();
	}
	
	// Ajout des infos d�j� remplies
	if (isset($_POST)&&!empty($_POST)){
	foreach ($netport->fields as $key => $val)
		if ($key!='ID'&&isset($_POST[$key]))
		$netport->fields[$key]=$_POST[$key];
	}
	
	
	echo "<div align='center'>";
	echo "<p><a class='icon_consol' href='$REFERER'>".$lang["buttons"][13]."</a></p>";
	
	echo "<form method='post' action=\"$target\">";

	echo "<input type='hidden' name='referer' value='$REFERER'>";
	echo "<table class='tab_cadre'><tr>";
	
	echo "<th colspan='4'>".$lang["networking"][20].":</th>";
	echo "</tr>";

	if ($several!="yes"){
	echo "<tr class='tab_bg_1'><td>".$lang["networking"][21].":</td>";
	echo "<td><input type='text' size='5' name='logical_number' value=\"".$netport->fields["logical_number"]."\">";
	echo "</td></tr>";
	}
	else {
	echo "<tr class='tab_bg_1'><td>".$lang["networking"][21].":</td>";
	echo "<input type='hidden' name='several' value='yes'>";
	echo "<input type='hidden' name='logical_number' value=''>";
	echo "<td>";
	echo $lang["networking"][47].":<select name='from_logical_number'>";
	for ($i=0;$i<100;$i++)
		echo "<option value='$i'>$i</option>";
	echo "</select>";
	echo $lang["networking"][48].":<select name='to_logical_number'>";
	for ($i=0;$i<100;$i++)
		echo "<option value='$i'>$i</option>";
	echo "</select>";

	echo "</td></tr>";
	}
	
	echo "<tr class='tab_bg_1'><td>".$lang["networking"][0].":</td>";
	echo "<td><input type='text' size='20' name='name' value=\"".$netport->fields["name"]."\">";
	echo "</td></tr>";

	echo "<tr class='tab_bg_1'><td>".$lang["networking"][16].":</td><td>";
		dropdownValue("glpi_dropdown_iface","iface", $netport->fields["iface"]);
	echo "</td></tr>";

	echo "<tr class='tab_bg_1'><td>".$lang["networking"][14].":</td>";
	echo "<td><input type='text' size='20' name='ifaddr' value=\"".$netport->fields["ifaddr"]."\">";
	echo "</td></tr>\n";

	// Show device MAC adresses
	if ((!empty($netport->device_type)&&$netport->device_type==1)||($several!="yes"&&$devtype==1)){
		$comp=new Computer();

		if (!empty($netport->device_type))
		$comp->getFromDB($netport->device_ID);
		else 
		$comp->getFromDB($ondevice);
		$macs=array();
		$i=0;
		// Get MAC adresses :
		if (count($comp->devices)>0)	
			foreach ($comp->devices as $key => $val)
				if ($val['devType']==NETWORK_DEVICE&&!empty($val['specificity'])){
					$macs[$i]=$val['specificity'];
					$i++;
					}
		if (count($macs)>0){
			echo "<tr class='tab_bg_1'><td>".$lang["networking"][15].":</td><td>";
			echo "<select name='pre_mac'>";
			echo "<option value=''>------</option>";
			foreach ($macs as $key => $val){
			echo "<option value='".$val."' >$val</option>";	
			}
			echo "</select>";

			echo "</td></tr>\n";

			echo "<tr class='tab_bg_2'><td>&nbsp;</td>";
			echo "<td>".$lang["networking"][57];
			echo "</td></tr>\n";
			
		}
	}
	
	echo "<tr class='tab_bg_1'><td>".$lang["networking"][15].":</td>";
	echo "<td><input type='text' size='25' name='ifmac' value=\"".$netport->fields["ifmac"]."\">";
	echo "</td></tr>\n";
	
	if ($several!="yes"){
	echo "<tr class='tab_bg_1'><td>".$lang["networking"][51].":</td>";
	
	echo "<td align='center' >";
		dropdownValue("glpi_dropdown_netpoint","netpoint", $netport->fields["netpoint"]);		
//		NetpointLocationSearch($search,"netpoint",$location,$netport->fields["netpoint"]);
//        echo "<input type='text' size='10'  name='search'>";
//	echo "<input type='submit' value=\"".$lang["buttons"][0]."\" name='Modif_Interne' class='submit'>";
	echo "</td></tr>";
	}
	if ($ID) {
/*		echo "<tr class='tab_bg_1'><td>".$lang["networking"][24].":</td>";
		echo "<td>";
			showConnection($netport->fields["ID"]);
		echo "</td></tr>";
*/
		echo "<tr class='tab_bg_2'>";
		echo "<td align='center'>";
		echo "<input type='hidden' name='ID' value=".$netport->fields["ID"].">";
		echo "<input type='submit' name='update' value=\"".$lang["buttons"][7]."\" class='submit'>";
		echo "</td>";
//		echo "</form>";
		
//		echo "<form method='post' action=$target>";
//		echo "<input type='hidden' name='ID' value=$ID>";
//		echo "<input type='hidden' name='referer' value='$REFERER'>";
		echo "<td align='center'>";
		echo "<input type='submit' name='delete' value=\"".$lang["buttons"][6]."\" class='submit'>";
		echo "</td></tr>";
	} else 
	{

		echo "<tr class='tab_bg_2'>";
		echo "<td align='center' colspan='2'>";
		echo "<input type='hidden' name='on_device' value='$ondevice'>";
		echo "<input type='hidden' name='device_type' value='$devtype'>";
		echo "<input type='submit' name='add' value=\"".$lang["buttons"][8]."\" class='submit'>";
		echo "</td></tr>";
	}

	echo "</table></form></div>";	
	// SHOW VLAN 
	if ($ID){
	echo "<div align='center'>";
	echo "<form method='post' action=\"$target\">";
	echo "<input type='hidden' name='referer' value='$REFERER'>";
	echo "<input type='hidden' name='ID' value='$ID'>";

	echo "<table class='tab_cadre'><tr class='tab_bg_2'><td>";
	showPortVLAN($netport->fields["ID"],0,$REFERER);
	echo "</td></tr>";
	
	echo "<tr  class='tab_bg_2'><td>";
	echo $lang["networking"][55].":&nbsp;";
	dropdown("glpi_dropdown_vlan","vlan");
	echo "<input type='submit' name='assign_vlan' value='".$lang["buttons"][3]."' class='submit'>";
	echo "</td></tr>";
	
	echo "</table>";
	
	echo "</form>";
	


	
	echo "</div>";	

		
	}
}

function addNetport($input) {
	// Add Netport, nasty hack until we get PHP4-array-functions

	$netport = new Netport;
	
	// dump status
	unset($input['add']);
	unset($input['search']);

	// fill array for update 
	foreach ($input as $key => $val) {
		if ($key[0]!='_'&&(!isset($netport->fields[$key]) || $netport->fields[$key] != $input[$key])) {
			$netport->fields[$key] = $input[$key];
		}
	}
	
	return $netport->addToDB();
}

function updateNetport($input) {
	// Update a port

	$netport = new Netport;
	$netport->getFromDB($input["ID"]);

	// Fill the update-array with changes
	$x=0;
	$updates=array();
	foreach ($input as $key => $val) {
		if (array_key_exists($key,$netport->fields) && $netport->fields[$key] != $input[$key]) {
			$netport->fields[$key] = $input[$key];
			$updates[$x] = $key;
			$x++;
		}
	}
	$netport->updateInDB($updates);
}

function deleteNetport($input) {
	
	// Delete Netwire
	removeConnector($input["ID"]);	

	// Delete Netport
	$netport = new Netport;
	$netport->deleteFromDB($input["ID"]);



} 

function showPortsAdd($ID,$devtype) {
	
	GLOBAL $cfg_layout, $cfg_install, $lang;
	$db = new DB;
	switch($devtype) {
		case COMPUTER_TYPE :
			$device_real_table_name = "glpi_computers";
			break;
		case NETWORKING_TYPE :
			$device_real_table_name = "glpi_networking";
			break;
		case PRINTER_TYPE :
			$device_real_table_name = "glpi_printers";
			break;
		case PERIPHERAL_TYPE :
			$device_real_table_name = "glpi_peripherals";
			break;
	}
	$query = "SELECT location from ".$device_real_table_name." where ID = ".$ID."";
	$location = $db->result($db->query($query),0,"location");

	echo "<div align='center'><table class='tab_cadre' width='90%' cellpadding='2'>";
	echo "<tr>";
	echo "<td align='center' class='tab_bg_2'  >";
	echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?on_device=$ID&amp;device_type=$devtype&amp;location=$location\"><b>";
	echo $lang["networking"][19];
	echo "</b></a></td>";
	echo "<td align='center' class='tab_bg_2' width='50%'>";
	echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?on_device=$ID&amp;device_type=$devtype&amp;several=yes&amp;location=$location\"><b>";
	echo $lang["networking"][46];
	echo "</b></a></td>";

	echo "</tr>";
	echo "</table></div><br>";
}

function showConnection ($ID,$withtemplate='',$type=COMPUTER_TYPE) {

	GLOBAL $cfg_layout, $cfg_install, $lang;

	$contact = new Netport;
	if ($contact->getContact($ID)) {
		$netport = new Netport;
		$netport->getfromDB($contact->contact_id);
		$netport->getDeviceData($netport->fields["on_device"],$netport->fields["device_type"]);
		echo "\n\n<table border='0' cellspacing='0' width='100%'><tr ".($netport->deleted=='Y'?"class='tab_bg_2_2'":"").">";
		echo "<td><b>";
		echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?ID=".$netport->fields["ID"]."\">";
		if (rtrim($netport->fields["name"])!="")
			echo $netport->fields["name"];
		else echo $lang["common"][0];
		echo "</a></b>";
		echo " ".$lang["networking"][25]." <b>";
		if ($netport->fields["device_type"]==COMPUTER_TYPE) {
			echo "<a href=\"".$cfg_install["root"]."/computers/computers-info-form.php?ID=".$netport->device_ID."\">";
		} else if ($netport->fields["device_type"]==NETWORKING_TYPE) {
			echo "<a href=\"".$cfg_install["root"]."/networking/networking-info-form.php?ID=".$netport->device_ID."\">";
		} else if ($netport->fields["device_type"]==PRINTER_TYPE) {
			echo "<a href=\"".$cfg_install["root"]."/printers/printers-info-form.php?ID=".$netport->device_ID."\">";
		} else if ($netport->fields["device_type"]==PERIPHERAL_TYPE) {
			echo "<a href=\"".$cfg_install["root"]."/peripherals/peripherals-info-form.php?ID=".$netport->device_ID."\">";
		}
		echo $netport->device_name." (".$netport->device_ID.")";
		echo "</a>";
		echo "</b></td>";
		echo "<td align='right'><b>";
		if ($withtemplate!=2)
		echo "<a href=\"".$cfg_install["root"]."/networking/networking-port-disconnect.php?ID=$ID\">".$lang["buttons"][10]."</a>";
		else "&nbsp;";
		echo "</b></td>";
		echo "</tr></table>";
		
	} else {
		echo "<table border='0' cellspacing='0' width='100%'><tr>";
		echo "<td>".$lang["networking"][26]."</td>";
		echo "<td align='right'>";
		if ($withtemplate!=2&&$withtemplate!=1){
			echo "<form method='post' action=\"".$cfg_install["root"]."/networking/networking-port-connect.php\">";
			echo "<input type='hidden' name='connect' value='connect'>";
			echo "<input type='hidden' name='sport' value='$ID'>";
			dropdownConnectPort($ID,$type,"dport");
			echo "<input type='submit' value=\"".$lang["buttons"][9]."\" class='submit'>";
			echo "</form>";
			}
//		echo "<a href=\"".$cfg_install["root"]."/networking/networking-port-connect.php?ID=$ID\">".$lang["buttons"][9]."</a>";
		else echo "&nbsp;";
		echo "</td>";
		echo "</tr></table>";
	}
}	


///// Wire the Ports /////

// Plus utilis�
/*
function showConnectorSearch($target,$ID) {

	GLOBAL $cfg_layout,$cfg_install, $lang;

	$np=New NetPort();
	$np->getFromDB($ID);
	$ci=new CommonItem;
	$ci->getFromDB($np->fields['device_type'],$np->fields['on_device']);
	echo "<div align='center'><form method='post' action=\"$target\"><table border='0' class='tab_cadre'>";
	echo "<tr><th colspan='2'>".$lang["networking"][27]." ".$ci->getName()." - ".$np->fields["logical_number"]." ".$lang["networking"][28].":</th></tr>";

	echo "<tr class='tab_bg_1'>";
	
	echo "<td>".$lang["networking"][29]." <select name='type'>";
	echo "<option value='name'>".$lang["networking"][0]."</option>";
	echo "<option value='id'>ID</option>";
	echo "</select>";
	echo $lang["networking"][30]." <input type='text' size='10' name='comp'>";
	echo "<input type='hidden' name='pID1' value=\"$ID\">";
	echo "<input type='hidden' name='next' value=\"compsearch\">";
	echo "</td><td class='tab_bg_2'>";
	echo "<input type='submit' value=\"".$lang["buttons"][11]."\" class='submit'>";
	echo "</td></tr>";	
	echo "</form>";
	
	echo "<tr class='tab_bg_1'>";
	echo "<form method='get' action=\"$target\">";
	echo "<td>".$lang["networking"][31].":";
	$db = new DB;
	$query = "SELECT glpi_networking.ID AS ID, glpi_networking.name AS name, glpi_dropdown_locations.ID as location from glpi_networking LEFT JOIN glpi_dropdown_locations ON glpi_networking.location = glpi_dropdown_locations.id WHERE glpi_networking.is_template='0' AND glpi_networking.deleted='N' ORDER BY name";
	$result = $db->query($query);
	$number = $db->numrows($result);
	echo "<select name='dID'>";
	$i=0;
	while ($i < $number)
	{
		$dID = $db->result($result, $i, "ID");
		$name = $db->result($result, $i, "name");
		$location = $db->result($result, $i, "location");
		echo "<option value=\"$dID\">$name (".getTreeValueCompleteName("glpi_dropdown_locations",$location).")</option>";
		$i++;
	}
	echo "</select>";
	echo "<input type='hidden' name='pID1' value=\"$ID\">";
	echo "<input type='hidden' name='next' value=\"showports\">";
	echo "<input type='hidden' name='device_type' value='2'>";
	echo "</td><td class='tab_bg_2'>";
	echo "<input type='submit' value=\"".$lang["buttons"][11]."\" class='submit'>";
	echo "</td></tr>";
	echo "</table>";
	echo "</form>";	
}
*/
// Plus utilis�
/*
function listConnectorComputers($target,$input) {
	
	GLOBAL $cfg_layout,$cfg_install, $lang;

	$pID1 = $input["pID1"];


	$db = new DB;
	if ($input["type"] == "name") {
		$query = "SELECT glpi_computers.ID as ID, glpi_computers.name as name, glpi_dropdown_locations.ID as location from glpi_computers LEFT JOIN glpi_dropdown_locations ON  glpi_computers.location = glpi_dropdown_locations.id WHERE glpi_computers.name LIKE '%".$input["comp"]."%'";
	} else {
		$query = "SELECT glpi_computers.ID as ID, glpi_computers.name as name, glpi_dropdown_locations.ID as location from glpi_computers LEFT JOIN glpi_dropdown_locations ON glpi_computers.location = glpi_dropdown_locations.id WHERE glpi_computers.ID LIKE '%".$input["comp"]."%'";
	} 
	
	$query.=" AND glpi_computers.is_template='0' and glpi_computers.deleted='N' ";
//echo $query;
	$query.= " ORDER BY glpi_computers.name";
	$result = $db->query($query);
	$number = $db->numrows($result);
	if ($number==0){
		echo "<div align=\"center\"><strong>";
		echo $lang["computers"][32]."<br>";
		echo "<a href=\"javascript:history.back()\">".$lang["buttons"][13]."</a>";
		echo "</strong></div>";
		return;
	}

	echo "<div align='center'><form method='get' action=\"$target\"><table border='0' class='tab_cadre'>";
	echo "<tr><th colspan='2'>".$lang["networking"][27]." $pID1 ".$lang["networking"][32].". ".$lang["networking"][33].":</th></tr>";
	echo "<tr><td>";

	echo "<tr class='tab_bg_1'>";
	echo "<td align='center'>";
	
		
	echo "<select name='dID'>";
	$i=0;
	while ($i < $number)
	{
		$dID = $db->result($result, $i, "ID");
		$name = $db->result($result, $i, "name");
		$location = $db->result($result, $i, "location");
		echo "<option value=\"$dID\">$dID - $name (".getTreeValueCompleteName("glpi_dropdown_locations",$location).")</option>";
		$i++;
	}
	echo  "</select>";

	echo "</td>";
	echo "<td class='tab_bg_2' align='center'>";
	echo "<input type='hidden' name='device_type' value='1'>";
	echo "<input type='hidden' name='pID1' value=\"".$pID1."\">";
	echo "<input type='hidden' name='next' value=\"showports\">";
	echo "<input type='submit' value=\"".$lang["buttons"][11]."\">";
	echo "</td></tr></table></form>";	

}
*/
//Plus utilis�
/*
function listConnectorPorts($target,$input) {

	GLOBAL $cfg_layout,$cfg_install,$lang;
	
	$pID1 = $input["pID1"];

	$db = new DB;
	$query = "SELECT * FROM glpi_networking_ports WHERE (on_device = ".$input["dID"]." AND device_type = ".$input["device_type"].") ORDER BY logical_number";
	$result = $db->query($query);
	$number = $db->numrows($result);

	if ($number < 1) {
		echo "<div align='center'><b>".$lang["networking"][34]."</b></div>";
	} else {

		echo "<div align='center'><table border='0' cellspacing=2 width='90%' class='tab_cadre'>";
		echo "<tr><th>".$lang["networking"][27]." $pID1 ".$lang["networking"][35].". ".$lang["networking"][36]." ".$input["dID"].":</th></tr>";
		echo "</table></div>";

		echo "\n\n<br><div align='center'><table border='0' cellpadding='2' width='90%' class='tab_cadre'>";
		echo "<tr><th>#</th><th>".$lang["networking"][0]."</th><th>".$lang["networking"][51]."</th>";
		echo "<th>".$lang["networking"][14]."</th><th>".$lang["networking"][15]."</th>";
		echo "<th>".$lang["networking"][16]."</th><th>".$lang["networking"][17].":</th></tr>\n";

		while ($data = $db->fetch_array($result)) {
			$pID2 = $data["ID"];
		
			$contact = new Netport;
			
			echo "<tr class='tab_bg_1'>";
			echo "<td>".$data["logical_number"]."</td>";
			echo "<td>";
			echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?ID=".$data["ID"]."\">";
			echo $data["name"];
			echo "</a>";
			echo "</td>";
			echo "<td>".getDropdownName("glpi_dropdown_netpoint",$data["netpoint"])."</td>";			
			echo "<td>".$data["ifaddr"]."</td>";
			echo "<td>".$data["ifmac"]."</td>";
			echo "<td>".getDropdownName("glpi_dropdown_iface",$data["iface"])."</td>";
			echo "<td>";

			if ($contact->getContact($pID2)) {
				$netport = new Netport;
				$netport->getfromDB($contact->contact_id);
				$netport->getDeviceData($netport->fields["on_device"],$netport->fields["device_type"]);
				echo "\n\n<table border='0' cellspacing='0' width='100%'><tr>";
				echo "<td>";
				echo "<a href=\"".$cfg_install["root"]."/networking/networking-port.php?ID=".$netport->fields["ID"]."\">";
				echo $netport->fields["name"];
				echo "</a> ";
				echo $lang["networking"][25];
				echo " <a href=\"".$cfg_install["root"]."/computers/computers-info-form.php?ID=".$netport->device_ID."\">";
				echo $netport->device_name." (".$netport->device_ID.")";
				echo "</a>";
				echo "</td>";
				echo "<td align='right'><b>";
				echo "<a href=\"".$cfg_install["root"]."/networking/networking-port-disconnect.php?ID=".$netport->fields["ID"];
				if (!empty($pID1)) echo "&amp;sport=$pID1";
				echo "\">".$lang["buttons"][10]."</a>";
				echo "</b></td>";
				echo "</tr></table>";
		
			} else {
				echo "<table border='0' cellspacing='0' width='100%'><tr>";
				echo "<td>".$lang["networking"][26]."</td>";
				echo "<td align='right'><b>";
				echo "<a href=\"$target?next=connect&amp;sport=$pID1&amp;dport=$pID2\">".$lang["buttons"][9]."</a>";
				echo "</b></td>";
				echo "</tr></table>";
			}
			
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
*/

function makeConnector($sport,$dport) {

	GLOBAL $cfg_layout, $cfg_install, $lang;
	
	$db = new DB;
	// Get netpoint for $sport and $dport
	$ps=new Netport;
	$ps->getFromDB($sport);
	$nps="";
	$ips="";
	$macs="";
	if (isset($ps->fields["netpoint"])&&$ps->fields["netpoint"]!=0)
		$nps=$ps->fields["netpoint"];
	if (isset($ps->fields["ifaddr"]))
		$ips=$ps->fields["ifaddr"];
	if (isset($ps->fields["ifmac"]))
		$macs=$ps->fields["ifmac"];
		
		
	$pd=new Netport;
	$pd->getFromDB($dport);
	$npd="";
	$ipd="";
	$macd="";
	if (isset($pd->fields["netpoint"])&&$pd->fields["netpoint"]!=0)
		$npd=$pd->fields["netpoint"];
	if (isset($pd->fields["ifaddr"]))
		$ipd=$pd->fields["ifaddr"];
	if (isset($pd->fields["ifmac"]))
		$macd=$pd->fields["ifmac"];

	// Update unknown IP
	$updates[0]="ifaddr";
	if (empty($ips)&&!empty($ipd)){
		$ps->fields["ifaddr"]=$ipd;
		$ps->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][19]."</b></div>";
		}
	else if (!empty($ips)&&empty($ipd)){
		$pd->fields["ifaddr"]=$ips;		
		$pd->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][19]."</b></div>";
		}
	else if ($ips!=$ipd){
		echo "<div align='center'><b>".$lang["connect"][20]."</b></div>";
		}
	// Update unknown MAC
	$updates[0]="ifmac";
	if (empty($macs)&&!empty($macd)){
		$ps->fields["ifmac"]=$macd;
		$ps->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][21]."</b></div>";
		}
	else if (!empty($macs)&&empty($macd)){
		$pd->fields["ifmac"]=$macs;		
		$pd->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][21]."</b></div>";
		}
	else if ($macs!=$macd){
		echo "<div align='center'><b>".$lang["connect"][22]."</b></div>";
		}
	// Update unknown netpoint
	$updates[0]="netpoint";
	if (empty($nps)&&!empty($npd)){
		$ps->fields["netpoint"]=$npd;
		$ps->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][17]."</b></div>";
		}
	else if (!empty($nps)&&empty($npd)){
		$pd->fields["netpoint"]=$nps;		
		$pd->updateInDB($updates);
		echo "<div align='center'><b>".$lang["connect"][17]."</b></div>";
		}
	else if ($nps!=$npd){
		echo "<div align='center'><b>".$lang["connect"][18]."</b></div>";
		}
	
	$query = "INSERT INTO glpi_networking_wire VALUES (NULL,$sport,$dport)";
	if ($result = $db->query($query)) {
		$source=new CommonItem;
		$source->getFromDB($ps->fields['device_type'],$ps->fields['on_device']);
		$dest=new CommonItem;
		$dest->getFromDB($pd->fields['device_type'],$pd->fields['on_device']);
		echo "<br><div align='center'><b>".$lang["networking"][44]." ".$source->getName()." - ".$ps->fields['logical_number']."  (".$ps->fields['ifaddr']." - ".$ps->fields['ifmac'].") ".$lang["networking"][45]." ".$dest->getName()." - ".$pd->fields['logical_number']." (".$pd->fields['ifaddr']." - ".$pd->fields['ifmac'].") </b></div>";
		return true;
	} else {
		return false;
	}

}

function removeConnector($ID) {

	GLOBAL $cfg_layout, $cfg_install;
	
	// Update to blank networking item
	$nw=new Netwire;
	if ($ID2=$nw->getOppositeContact($ID)){
	
	$np1=new Netport;
	$np2=new Netport;
	$np1->getFromDB($ID);
	$np2->getFromDB($ID2);
	$npnet=-1;
	$npdev=-1;
	if ($np1->fields["device_type"]!=NETWORKING_TYPE&&$np2->fields["device_type"]==NETWORKING_TYPE){
		$npnet=$ID2;
		$npdev=$ID;
		}
	if ($np2->fields["device_type"]!=NETWORKING_TYPE&&$np1->fields["device_type"]==NETWORKING_TYPE){
		$npnet=$ID;
		$npdev=$ID2;
		}
	$db = new DB;
	if ($npnet!=-1&&$npdev!=-1){
		// Unset MAC and IP fron networking device
		$query = "UPDATE glpi_networking_ports SET ifaddr='', ifmac='' WHERE ID='$npnet'";	
		$db->query($query);
		// Unset netpoint from common device
		$query = "UPDATE glpi_networking_ports SET netpoint=NULL WHERE ID='$npdev'";	
		$db->query($query);

	}
	
	$query = "DELETE FROM glpi_networking_wire WHERE (end1 = '$ID' OR end2 = '$ID')";
	if ($result=$db->query($query)) {
		return true;
	} else {
		return false;
	}
	} else return false;
}


?>
