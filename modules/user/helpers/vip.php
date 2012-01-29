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

/**
 * CutGallery - 
 * This is the API for handling vip users.
 *
 * Note: by design, this class does not do any permission checking.
 */

/**
 * Query 'users' table for all the VIP users who have '_VIP' as suffix.
 */
class vip_Core {
    static function lookup_vip_users() {
        $vip_users = array();
        $users = array();
        
        $users = db::build()
                ->select("name")
                ->from("users")
                ->where("name", "!=", "guest")
                ->and_where("admin", "!=", "1")
                ->order_by("name", "ASC")
                ->execute()->as_array(TRUE);
        
        foreach ($users as $user){
            $suffix = substr($user[name], strlen($user[name]) - 4);
            if (strcmp($suffix, "_VIP") == 0) {
                array_push($vip_users, $user[name]);
            }
        }
        
        return $vip_users;
    }
}
