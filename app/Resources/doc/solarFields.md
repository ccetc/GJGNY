// changes
// =========
//new outreach organization options: "ETM" and "STSW"
// new lead type option: "solar"

//data/manual changes
//===========
// add counties: Bradford, Susquehanna, WAYNE, TIOGA PA

new fields
=============
category - array
	options:
		homeowner
		renter
		landlord
		commercial
		nonprofit
		municipal
		school
		residential (1-4 unit)
		multifamily

// leadTypeSolar

//Solar Type (group together)
//	solarTypePV - bool - "PV"
//	solarTypeHotWater - bool - "hot water"

Solar Upgrades (new form/show group)
	solarUpgradeStatus - string 255
		choices:
			site assessment requested
			site assessment scheduled
			NYSERDA submitted
			NYSERDA approved
			building permit submitted
			building permit approved
			financing application submitted
			financing application approved
			interconnection submitted
			interconnection tech approved
			interconnection completed
			installation completed
	solarDate1 - "site assessment requested" - date
	solarDate2 - "site assessment scheduled" - date
	solarDate3 - "NYSERDA submitted" - date
	solarDate4 - "NYSERDA approved" - date
	solarDate5 - "building permit submitted" - date
	solarDate6 - "building permit approved" - date
	solarDate7 - "financing application submitted" - date
	solarDate8 - "financing application approved" - date
	solarDate9 - "interconnection submitted" - date
	solarDate10 - "interconnection tech approved" - date
	solarDate11 - "interconnection completed" - date
	solarDate12 - "installation completed" - date

NOTE: use the choice array to add form/show fields for dates

 
on update
================
- UPDATE Lead SET category = NULL;
- update old category fields:

match these to new field
        'Residential (1-4 Unit)' => 'Residential (1-4 Unit)',
        'Multifamily' => 'Multifamily',
        "Commercial / Non-Profit / Gov't" => "Commercial / Non-Profit / Gov't",

match homeowner, renter, landlord to new field

