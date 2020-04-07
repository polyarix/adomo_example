# server-based syntax
# ======================
# Defines a single server with a list of roles and multiple properties.
# You can define all roles on a single server, or split them:

# server "example.com", user: "deploy", roles: %w{app db web}, my_property: :my_value
# server "example.com", user: "deploy", roles: %w{app web}, other_property: :other_value
# server "db.example.com", user: "deploy", roles: %w{db}
server 'example.com', user: 'webwork', roles: %w{app db web}, port: 5253

set :deploy_via, :copy
set :deploy_to, "~/www/html"
set :branch, 'dev'

set :laravel_artisan_flags, "--env=dev"
set :laravel_migration_roles, :all
set :laravel_migration_artisan_flags, "--force --env=dev"
set :laravel_version, 5.8
set :laravel_upload_dotenv_file_on_deploy, false
set :laravel_ensure_linked_dirs_exist, true
set :laravel_set_linked_dirs, true

set :laravel_5_linked_dirs, [
  'storage'
]

set :laravel_ensure_acl_paths_exist, true
set :laravel_set_acl_paths, true
set :laravel_5_acl_paths, [
  'bootstrap/cache',
  'storage',
  'storage/app',
  'storage/app/public',
  'storage/framework',
  'storage/framework/cache',
  'storage/framework/sessions',
  'storage/framework/views',
  'storage/logs'
]

namespace :deploy do
    after :published, "composer:install"
    after :published, "laravel:optimize"
    after :published, "laravel:migrate"
    # after :published, "laravel:seed"
end
