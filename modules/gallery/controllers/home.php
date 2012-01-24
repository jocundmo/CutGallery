<?php defined("SYSPATH") or die("No direct script access.");
class Home_Controller extends Controller {
    public function index() {
        $template = new Theme_View("page.html");
        $template->content = new View("home.html");
        print $template;
    }
}
