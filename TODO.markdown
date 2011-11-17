GJGNY - TODO ====================================================
=================================================================

ideas
====================================
	
	- simpler create form?

1.1
============================

//	1.	git init
	
//	2.	github
	
	3.	add bundles
	
//		- Admin
		
//		- DoctrineAdmin
		
//		- Help
		
//		- User Admin
	
//		- user
	
//		- Knp
	
	10.	Misc
	
		- remove old bundles
	
		- Error templates
		
		- config
		
		- routing
		
		- appkernel
		
		- autoload
	
		
	
1.2
============================

	0.	features lost from new Admin

		- Lead Events
		
			- use preFormHook
			
				-> may need to modify to include object
	
	
		- Other fields
		
			-> use preFieldHook AND postFieldHook
			
			
		- Form fields to indent
	
			-> use preFieldHook AND postFieldHook
	
		- edit description
		
			- formPreHook
			
		- entity description
		
			- listPreHook!		
			
		- extra form Labels (for groups)
		
			- use preFormFieldHooks
			
		- parent fields/labels on show
		
			- use preShowFieldHooks

		- Lead name duplication
		
		- user levels
		
			- hide some entities on dashboard
		
			- hide Create link in base_list.html.twig sometimes
		
				- find a way to define which admins should not have this
		
					- now checks that the route is defined?
			
				- would like to disable create/edit for some entities / some users

				- on create/update redirect to list if show is not a route

	
	1.	Excel exporting
	
		- export all?most? fields from filter result
	
	
	2.	Make Program Source a drop down field
	
		a. Form
		
			- dropdown + other

				- include only county programs
			
			- autofill information?
			

		b.	Filter
		
			- dropdown
			
				- include only county programs
			
	
	3.	Report Summaries
	
		- summarize certain fields for objects in filter results
	
	
	4.	Refinements
	
		- add help fields
		
	
	10.	Performance
	
		- does new Admin help at all?  I hope so
		
			- ask Jim about server statistics
			
	
	11.	small misc changes
	
		- add renter/landlord/homeowner checkboxes
		
		- default to current date

		- add button to lead page to create an event for that lead

		- add interns to notification e-mails

		- check address when creating lead to limit duplicates
		

	12.	Misc	

		a.	move Tompkins LUT data to Lead
		
		b.	trim values?
		
		c.	follow up in 2 weeks button
		
		d.	date picker?
		

1.3		
===============================

	1.	Excel importing
	
		- downloadable template
		
			- not all fields
			
				- basic info + event
				
				
	10.	Cleanup
	
		a.  counties choices (broome/Tompkins) in admin classes and elsewhere!
	
			- config emails
		
			- admin classes (choices)

			
		b.  make admin and county entities/interfaces
