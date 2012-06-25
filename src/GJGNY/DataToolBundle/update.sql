UPDATE Lead SET upgradeStatus="Referred to WAP / Empower", leadStatus="" WHERE leadStatus="referred out of program";
UPDATE Lead SET leadStatus="upgrade complete" WHERE leadStatus="process complete";

UPDATE Lead SET leadStatus='upgrade complete' WHERE id=346;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=1064;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=1160;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=1167;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=1170;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=1213;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=2046;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=2447;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=2448;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=2643;
UPDATE Lead SET leadStatus='upgrade complete' WHERE id=2645;

UPDATE Lead SET upgradeStatus='Interested in assessment - No app submitted' WHERE step2aInterested=1
UPDATE Lead SET upgradeStatus='GJGNY app submitted' WHERE step2bSubmitted=1
UPDATE Lead SET upgradeStatus='Assessment Complete' WHERE step2dCompleted=1
UPDATE Lead SET upgradeStatus='Upgrade Complete' WHERE step3=1


