

directory "/www/connection" do
	owner "deploy"
	group "apache"
end

cookbook_file "/www/connection/index.php" do
  source "index.php"
  mode "0644"
  owner "deploy"
  group "apache"
end


serverName = "#{node.name}.keboola.com"
web_app serverName do
	template "connection.keboola.com.conf.erb"
  server_name serverName
  server_aliases [node['hostname']]
  docroot "/www/connection"
  enable true
end
