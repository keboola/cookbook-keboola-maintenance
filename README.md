keboola-generic-server Cookbook
===============================

Generic server cookbook and CloudFormation template.

Usage
-----
Log into AWS console and create new stack using https://github.com/keboola/cookbook-keboola-generic-server/blob/master/server.json

When the stack will be complete navigate browser to http://your-stack-name.keboola.com

Description 
-----------

This cookbook will install basic packages required by all Keboola servers using [Keboola Common Cookbook](https://github.com/keboola/cookbook-keboola-common).  Additionaly [PHP](https://github.com/keboola/cookbook-keboola-php) and [apache](https://github.com/keboola/cookbook-keboola-apache2) are installed.



Troubleshooting
---------------
Each step of instance provisioning provides logs, these can be helplful when something goes wrong during instance provisioning.

* `/var/log/cloud-init.log` - Cloud init script
* `/var/log/cfn-init.log` - Cloudformation init script
* `/var/init/bootstrap.log` - Downloading chef and required recipes using Berkshelf
* `/var/init/chef_solo.log` - Chef provisioning

If you want to run chef provisioning again run following command as root on provisioned instance:
`chef-solo --environment production  -j /var/init/node.json --config /var/init/solo.rb --node-name STACK_NAME`
