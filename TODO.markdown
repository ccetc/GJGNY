GJGNY - TODO ====================================================
=================================================================

0.0
============
	
	- relation field on Lead Event form!

	- bool on form
	
	- user admin
	
		- fix list labels
		
		- fix create

ideas
====================================
	
	- simpler create form?
	
	
roll out
====================================

	- run boolfix.sql
	
	- doctrine:schema:update --force
	
	- add interns to notification list	
	
	
1.2
============================

#	0.	features lost from new Admin

//		- Lead Events
			
//		- Other fields
					
//		- Form fields to indent
	
//		- edit description
		
//		- entity description
		
//		- extra form Labels (for groups)
		
//		- parent fields/labels on show
		
//		- show field indents
		
		- user levels
		
			- hide some entities on dashboard
		
			- hide Create link in base_list.html.twig sometimes
		
				- find a way to define which admins should not have this
		
					- now checks that the route is defined?
			
				- would like to disable create/edit for some entities / some users

				- on create/update redirect to list if show is not a route

	
//	1.	Excel exporting
	
//		- configure

//		- memory problem

//			- doctrine
			
//			- phpexcel
	
#	2.	Make Program Source a drop down field
	
		a. Form
		
			- dropdown + other

				- include only county programs
			
			- autofill information?
			

		b.	Filter
		
			- dropdown
			
				- include only county programs
			
	
//	3.	Report Summaries
	
//		- memory problem
		
//		- sum problem
	
#	4.	Refinements
	
		- add help fields
		
		- adjust date formats
	
//	10.	Performance
	
	
#	11.	small misc changes
	
//		- add renter/landlord/homeowner checkboxes
		
//		- default to current date

		- add button to lead page to create an event for that lead

//		- let notification e-mails handle multiple toAddresses

		- check address when creating lead to limit duplicates
		
				- double check Lead name duplication
		
//		- fix boolean yes/no/empty problem
		

1.3		
===============================

	1.	Excel importing
	
		- downloadable template
		
			- not all fields
			
				- basic info + event
			
	2.	Lead Events
	
			
				
	10.	Cleanup
	
		a.  counties choices (broome/Tompkins) in admin classes and elsewhere!
	
			- config emails
		
			- admin classes (choices)

			
		b.  make admin and county entities/interfaces


	12.	Misc	

		a.	move Tompkins LUT data to Lead
		
		b.	trim values?
		
		c.	follow up in 2 weeks button
		
		d.	date picker?
		
