#Json string District for maps collection
function getFeatureCollectionDistrict($IBLOCK_ID = 60, $ONLY_ARRAY = false) {
	if (CModule::IncludeModule("iblock")) {
		$FeatureCollection = $features = array();
		$arFilter = Array('IBLOCK_ID'=>intVal($IBLOCK_ID), 'GLOBAL_ACTIVE'=>'Y', 'ACTIVE'=>'Y');
		$db_list = CIBlockSection::GetList(Array("NAME"=>"ASC"), $arFilter, false, Array("UF_COORDINATS", "ID", "NAME"), false);
		while($ar_sect = $db_list->GetNext()) {
			if(!$ONLY_ARRAY){
				$features[] = array(
					"type" => "Feature",
					"id" => $ar_sect["ID"],
					"geometry" => array(
						"type" => "Polygon",
						"coordinates" => json_decode($ar_sect["UF_COORDINATS"]),
					),
					"properties" => array(
						"description" => $ar_sect["NAME"],
						"fill-opacity" => 0,
						"stroke-opacity" => 0,
						"stroke-width" => 0,
						"enum_id" => $ar_sect["ID"],
					),
				);
			} else {
				$features[$ar_sect["ID"]] = $ar_sect;
			}
		}
		if($features && !$ONLY_ARRAY){
			$FeatureCollection = array(
				"type" => "FeatureCollection",
	  			"metadata" => array(
					"name" => "Ufa districts",
					"creator" => "CIT"
  				),
  				"features" => $features
			);
			return json_encode($FeatureCollection);
		}
		if($ONLY_ARRAY){
			return 	$features;
		}
	} else {
		return "Module iblock not include";
	}	
}
