# GJGNY - README
The [GJGNY Data Tool](http://gjgny.ccext.net) is a Symfony project with no front end.  It is simply an interface to four database tables that energy outreach teams in Tompkins and Broome use to track information about home energy upgrade Leads.

## User Documentation
There is a HowTo document for users on google docs: <https://docs.google.com/document/d/1vF_RKP2v3gn9tHgKdNK724ksB1szY8ZVeO8Cx6Z_qiQ/edit>

## Cron Jobs
### E-mail digests
Once a week, the ``Digest`` Command is run.  This command sends a e-mail digest to the set of administrators defined in the config file outlining the number of Leads that need to be called.

### Lead status updates
Every day, the ``Lead`` Command is run.  This command updates all Leads awaiting follow-up who have reached their date of next follow-up by labelling them as "need to call".

## "Broken Windows" - areas for improvement
### Counties using the tool
There are about 10 places in the code where the set of counties using the data tool is hard coded.  This list of counties should only exist in one spot, and that should likely be a table in the database.

### "Sets" of boolean fields
The ``Lead`` Entity has many fields that are actually groups of boolean fields.  This is not easily supported by Doctrine or Sonata, and our implementation is shakey.

The messiest piece of this is the display of form fields and show fields.  Each of these fields and groups of fields has a set of pre/post hooks that give the groups labels, and indent the fields.  This is particularly confusing for the first field of each group, since in needs two pre hooks.
