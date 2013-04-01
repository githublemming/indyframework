Any files in this folder are included in order for certain functionality of
specific included Providers to work.

Any files found here are the work of 3rd party developers/companies and ARE NOT
part of the Indy Framework and as such are not bound by the license covering
this framework. They are included purely as example of what can be done.


If you plan to use the functionality these files offer the you should:
1) get the latest versions from there official home
2) check to ensure that any licenses assigned to these works are compatible with
   your application.
   
   
Amazon Web Services
-------------------
If you want to use any of the included AWS Service providers you will have to 
drop a copy of the AWS SDK into this directory.

Then at the top of the config file /indyframework/config.php you will need to 
update : define('AWS_SDK','aws-sdk-1.5.0/');  so that it has the correct directory
name in it.
