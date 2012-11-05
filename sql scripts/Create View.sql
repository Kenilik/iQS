CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `qallbarcodeinfo` AS
    select 
        'Equipment' AS `BarcodeType`,
        `equipment`.`ID` AS `ID`,
        `equipment`.`Name` AS `Name`,
        `equipment`.`BarcodeNo` AS `BarcodeNo`,
        `equipment`.`HomeSiteID` AS `SiteID`,
        `equipment`.`EquipTypeID` AS `EquipTypeID`,
        `equiptype`.`Name` AS `EquipTypeName`,
        `equipment`.`EquipStatusID` AS `StatusID`,
        `equipstatus`.`Status` AS `Status`,
        NULL AS `FirstName`,
        NULL AS `LastName`
    from
        ((`equipment`
        join `equiptype` ON ((`equipment`.`EquipTypeID` = `equiptype`.`ID`)))
        join `equipstatus` ON ((`equipment`.`EquipStatusID` = `equipstatus`.`ID`))) 
    union select 
        'User' AS `BarcodeType`,
        `user`.`ID` AS `ID`,
        `user`.`Username` AS `Name`,
        `user`.`BarcodeNo` AS `BarcodeNo`,
        `user`.`HomeSiteID` AS `HomeSiteID`,
        NULL AS `EquipTypeID`,
        NULL AS `EquipTypeName`,
        `user`.`UserStatusID` AS `StatusID`,
        `userstatus`.`Status` AS `Status`,
        `user`.`FirstName` AS `FirstName`,
        `user`.`LastName` AS `LastName`
    from
        (`user`
        join `userstatus` ON ((`user`.`UserStatusID` = `userstatus`.`ID`)))
        
        
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `qequipinuse` AS
    select 
        `equipregister`.`ID` AS `EquipRegID`,
        `equipment`.`ID` AS `EquipID`,
        `equiptype`.`ID` AS `EquipTypeID`,
        `equipregister`.`UserID` AS `UserID`,
        `equiptype`.`Name` AS `EquipTypeName`,
        `equipment`.`Name` AS `EquipName`,
        `equipment`.`BarcodeNo` AS `BarcodeNo`,
        `user`.`Username` AS `Username`,
        `user`.`FirstName` AS `FirstName`,
        `user`.`LastName` AS `LastName`,
        `equipregister`.`DTOut` AS `DTOut`,
        sec_to_time(timestampdiff(SECOND,
                    `equipregister`.`DTOut`,
                    now())) AS `TimeInUse`
    from
        ((`equiptype`
        join `equipment` ON ((`equiptype`.`ID` = `equipment`.`EquipTypeID`)))
        join (`user`
        join `equipregister` ON ((`user`.`ID` = `equipregister`.`UserID`))) ON ((`equipment`.`ID` = `equipregister`.`EquipID`)))
    where
        isnull(`equipregister`.`DTIn`)
    order by `equiptype`.`ID`