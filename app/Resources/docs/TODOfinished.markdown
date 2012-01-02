# GJGNY - TODOfinished

# 1.2.1	Small Changes from trainings
0. update sonata
 - check empty countyData filter
1.	quick field changes
 - change lead type to checkboxes
 	  - add workforce		
 - fix campaign typo
 - add a county filter
 - assessment complete
 - add more fields to spreadsheet
2.	Workforce
 a. Lead fields
     - highest education
     - certifications
	 - training experience
 b. Lead Events
 	 - move phone call fields
	 - training referral
	     - institution
		 - program
		 - date of referral
		 - date of completion
	 - job referral
		 - business
		 - date
3.	Other
 - create button at top
 - fix red flag
 - fix create user
	
		
# 1.2
0.	features lost from new Admin
 - Lead Events
 - Other fields
 - Form fields to indent
 - edit description
 - entity description
 - extra form Labels (for groups)
 - parent fields/labels on show
 - show field indents
 - user levels
1.	Excel exporting
 - configure
 - memory problem
     - doctrine
	 - phpexcel
2.	Make Program Source a drop down field
 - relation
     - auto set date
3.	Report Summaries
 - memory problem
 - sum problem
 - object problem
 - set memory
	 - in controller and class methods
 - other fields
	 - event type
4.	Refinements
 - add help fields
 - adjust date formats
 - add summary to Lead Events
5.	Auto Events
 - program source, call, e-mail				
10.	Performance
11.	small misc changes
 - add renter/landlord/homeowner checkboxes
 - default to current date
 - add button to lead page to create an event for that lead
 - let notification e-mails handle multiple toAddresses
 - check address when creating lead to limit duplicates
     - double check Lead name duplication
 - fix boolean yes/no/empty problem

# 1.1
1.	git init
2.	github
3.	add bundles
 - Admin
 - DoctrineAdmin
 - Help
      - work in
 - User Admin
	 - work in
 - user
	 - lost custom user fields and forms
 - Knp
 - bootstrap?
4.	Admin Syntax
 - fix filters	
10.	Misc
 - remove old bundles
 - Error templates
 - config
 - routing
 - appkernel
 - autoload

#1.0
0.	Speed up view
00.	Cross Browser Testing
1.	Leads
 a.	Model: update with new fields, groups and path steps
 b.	form
 c.	View
     - labels
	 - format	
	 - lead events!
 d.	List
	 - set up filters							
	 - hide filters
	     - check popup
2.	Events
 a. Model: update
 b. Form
	 - choices
	 - remove new button
 c. List
	 - set up filters
 d. View
 	 - Lead link
	 - format
	 - labels
3.	Misc
 -	route /home and / to dashboard 
 -	1toMany link to view instead of edit
 -	clean up the view template
 -	check db for lead
 -	404s
 -  user e-mails
 -	better manage admins
	 - use for approval needed e-mails sent to admins
	 - use for failed login
4.	Users
 - use just email
	 - remove user name from user permissions
	 - look elsewhere
 - customize templates
 - add info to header
 - account approval
 - test e-mails
	 - reset password
 - figure out homepage
 - add new fields
 - dashboard user permissions
5.	Data
 - add Broome fields
	 - update crud
 - refine Broome fields
     - make changes from phone call
 - import
6.	Misc Cleanup and Improvements
 a.	better filter for name on LeadEvent
 b.	fine-tuning
	 - import new data
	 - default county data filter
	 - error pages?
	 - result count
	 - command for marking leads as need to call
	     - every day at 3AM (eastern)
		 - for each Lead where date of next follow up is set and = today (in query?) leadStatus = need to call
		 - cron job
 	 - digests
		 - send a list of need to call leads by county to each admin every monday at 3am
		 - cron job
	 - user admin
		 - no edit
		 - create
		 - delete
	 - user profiles
		 - change password
	 - name filter bug: if both defined, AND, otherwise, or	