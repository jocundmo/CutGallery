<?php defined("SYSPATH") or die("No direct script access.");
class BrowserNotSupport_Controller extends Controller {
    public function index() {
        $template = new View("browser_not_support.html");

        print $template;
    }
}