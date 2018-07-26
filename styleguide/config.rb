# Require any additional compass plugins here.
require 'sass-globbing'
require 'fileutils'

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "source/css"
sass_dir = "source/css"
images_dir = "source/images"
javascripts_dir = "source/js"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :compressed
# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false



on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Copying: #{file} to " + File.dirname(file) + "/../../../wp-content/themes/summit/"
    FileUtils.copy_file(file, File.dirname(file) + "/../../../wp-content/themes/summit/" + File.basename(file))
	puts "Copied!";
  end
end