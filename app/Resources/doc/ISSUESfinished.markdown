# GJGNY - ISSUESfinished

1. name filters occasionally return empty results
	- Sonata bug here: <https://github.com/sonata-project/SonataAdminBundle/issues/536>
2. missing ACL object permissions for Portal Leads
	- use admin->create() instead of $em->create()