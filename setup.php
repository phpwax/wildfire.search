<?
AutoLoader::register_view_path("plugin", __DIR__."/view/");

AutoLoader::register_controller_path("plugin", __DIR__."/lib/controller/");
AutoLoader::register_controller_path("plugin", __DIR__."/resources/app/controller/");
AutoLoader::$plugin_array[] = array("name"=>"wildfire.search","dir"=>__DIR__);

?>