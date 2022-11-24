<?php
/**
 * Open Source Social Network
 * @link      https://www.opensource-socialnetwork.org/
 * @package   Restrict Group Creation
 * @author    Michael Zülsdorff <ossn@z-mans.net>
 * @copyright (C) Michael Zülsdorff
 * @license   GNU General Public License https://www.gnu.de/documents/gpl-2.0.en.html
 */

function com_restrict_group_creation_init() {
		ossn_register_callback('action', 'load', 'com_restrict_group_creation_disable_unauthorized_action');
		//Because group menus are registered in callback so unregistering in initilize callback of component
		//didn't work , changes were made in OSSN #2072
 		ossn_register_callback('menu', 'section:before:view', 'com_restrict_group_creation_sidemenus');
}
function com_restrict_group_creation_sidemenus() {
		if(ossn_isLoggedin()) {
				if(!ossn_loggedin_user()->isAdmin()) {
						ossn_unregister_menu_item('addgroup', 'groups', 'newsfeed');
				}
		}
}
function com_restrict_group_creation_disable_unauthorized_action($callback, $type, $params) {
		if(ossn_isLoggedin()) {
				if(!ossn_loggedin_user()->isAdmin() && $params['action'] == 'group/add') {
						redirect('home');
				}
		}
}
ossn_register_callback('ossn', 'init', 'com_restrict_group_creation_init');