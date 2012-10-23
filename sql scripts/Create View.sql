SELECT 
	'Equipment' AS `BarcodeType`,
	`Equipment`.`EquipID` AS `ID`,
	`Equipment`.`BarcodeNo` AS `BarcodeNo`,
	`Equipment`.`SiteID` as `SiteID`,
	`Equipment`.`EquipTypeID` AS `EquipTypeID`,
	`EquipType`.`EquipTypeDescr` AS `EquipTypeDescr`,
	`Equipment`.`EquipStatusID` AS `StatusID`,
	`EquipStatus`.`EquipStatusDescr` AS `StatusDescr`,
	NULL as `FirstName`,
	NULL AS `LastName`

FROM `Equipment`
	INNER JOIN `EquipType` ON `Equipment`.`EquipTypeID` = `EquipType`.`EquipTypeID`
	INNER JOIN `EquipStatus` ON `Equipment`.`EquipStatusID` = `EquipStatus`.`EquipStatusID`

UNION SELECT 
	'Member' AS `BarcodeType`,
	`Member`.`QID` AS `ID`,
	`Member`.`BarcodeNo` AS `BarcodeNo`,
	`Member`.`SiteID` as `SiteID`,
	NULL AS `EquipTypeID`,
	NULL AS `EquipTypeDescr`,
	`Member`.`MemStatusID` AS `StatusID`,
	`MemStatus`.`MemStatusDescr` AS `StatusDescr`,
	`Member`.`FirstName`  AS `FirstName`,
	`Member`.`LastName`  AS `LastName`

FROM `Member`
	INNER JOIN `MemStatus` `MemStatus` ON `Member`.`MemStatusID` = `MemStatus`.`MemStatusID`
