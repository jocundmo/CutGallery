<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2011 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class Photos_Controller extends Items_Controller {
  // CutGallery - ADDED ==>
  public function form_download($album, $photo){
      $document_root = $_SERVER['DOCUMENT_ROOT'];
      $site_domain = (string)Kohana::config('core.site_domain', TRUE);
      $file_path = $document_root.$site_domain."var/albums/".$album.'/'.$photo; // CutGallery - @TODO: Hard coded 'var/albums' temporary.
      download::dialog($file_path);
      download::send($file_path);
  }
  public function form_share($md5_combined_album_photo){
      $photo = ORM::factory("item")
              ->where("hashed_name", "=", $md5_combined_album_photo)->find();
      
      self::show($photo, true);
  }
  // <==
  public function show($photo, $is_shared=false) {
     if (!is_object($photo)) {
      // show() must be public because we route to it in url::parse_url(), so make
      // sure that we're actually receiving an object
      throw new Kohana_404_Exception();
    }

    if (!$is_shared) {
        access::required("view", $photo);
        
        $where = array(array("type", "!=", "album"));
        $position = item::get_position($photo, $where);
        if ($position > 1) {
            list ($previous_item, $ignore, $next_item) =
            $photo->parent()->viewable()->children(3, $position - 2, $where);
        } else {
            $previous_item = null;
            list ($next_item) = $photo->parent()->viewable()->children(1, $position, $where);
        }

        $template = new Theme_View("page.html", "item", "photo");
        $template->set_global(
        array("item" => $photo,
            "children" => array(),
            "children_count" => 0,
            "parents" => $photo->parents()->as_array(),
            "is_share" => false,
            "next_item" => $next_item,
            "previous_item" => $previous_item,
            "sibling_count" => $photo->parent()->viewable()->children_count($where),
            "position" => $position));

        $template->content = new View("photo.html");

        $photo->increment_view_count();

    }
    else {
        $template = new Theme_View("page.html", "item", "photo");
        $template->set_global(
        array("item" => $photo,
            "children" => array(),
            "children_count" => 0,
            "parents" => $photo->parents()->as_array(),
            "is_share" => true,
            "next_item" => null,
            "previous_item" => null,
            "sibling_count" => 0,
            "position" => 0));

        $template->content = new View("photo.html");
    }

/**
    $where = array(array("type", "!=", "album"));
    $position = item::get_position($photo, $where);
    if ($position > 1) {
      list ($previous_item, $ignore, $next_item) =
        $photo->parent()->viewable()->children(3, $position - 2, $where);
    } else {
      $previous_item = null;
      list ($next_item) = $photo->parent()->viewable()->children(1, $position, $where);
    }

    $template = new Theme_View("page.html", "item", "photo");
    $template->set_global(
      array("item" => $photo,
            "children" => array(),
            "children_count" => 0,
            "parents" => $photo->parents()->as_array(),
            "next_item" => $next_item,
            "previous_item" => $previous_item,
            "sibling_count" => $photo->parent()->viewable()->children_count($where),
            "position" => $position));

    $template->content = new View("photo.html");

    $photo->increment_view_count();
 * 
 */

    print $template;
  }

  public function update($photo_id) {
    access::verify_csrf();
    $photo = ORM::factory("item", $photo_id);
    access::required("view", $photo);
    access::required("edit", $photo);

    $form = photo::get_edit_form($photo);
    try {
      $valid = $form->validate();
      $photo->title = $form->edit_item->title->value;
      $photo->description = $form->edit_item->description->value;
      $photo->slug = $form->edit_item->slug->value;
      $photo->name = $form->edit_item->inputs["name"]->value;
      $photo->validate();
    } catch (ORM_Validation_Exception $e) {
      // Translate ORM validation errors into form error messages
      foreach ($e->validation->errors() as $key => $error) {
        $form->edit_item->inputs[$key]->add_error($error, 1);
      }
      $valid = false;
    }

    if ($valid) {
      $photo->save();
      module::event("item_edit_form_completed", $photo, $form);

      log::success("content", "Updated photo", "<a href=\"{$photo->url()}\">view</a>");
      message::success(
        t("Saved photo %photo_title", array("photo_title" => html::purify($photo->title))));

      if ($form->from_id->value == $photo->id) {
        // Use the new url; it might have changed.
        json::reply(array("result" => "success", "location" => $photo->url()));
      } else {
        // Stay on the same page
        json::reply(array("result" => "success"));
      }
    } else {
      json::reply(array("result" => "error", "html" => (string)$form));
    }
  }

  public function form_edit($photo_id) {
    $photo = ORM::factory("item", $photo_id);
    access::required("view", $photo);
    access::required("edit", $photo);

    print photo::get_edit_form($photo);
  }
}
