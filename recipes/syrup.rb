

directory "/www/syrup" do
	owner "deploy"
	group "apache"
end

cookbook_file "/www/syrup/index.php" do
  source "index-syrup.php"
  mode "0644"
  owner "deploy"
  group "apache"
end


web_app 'syrup.keboola.com' do
	template "syrup.keboola.com.conf.erb"
  server_name "syrup.keboola.com"
  server_aliases [node['hostname']]
  enable true
end
