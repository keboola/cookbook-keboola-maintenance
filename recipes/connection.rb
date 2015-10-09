

directory "/www/connection" do
	owner "deploy"
	group "apache"
end

cookbook_file "/www/connection/index.php" do
  source "index-connection.php"
  mode "0644"
  owner "deploy"
  group "apache"
end


web_app serverName do
	template "connection.keboola.com.conf.erb"
  server_name "connection.keboola.com"
  server_aliases [node['hostname']]
  enable true
end
