<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
//				http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'html1.php');

if (empty($routes)) die; // Don't allow to be called bypassing dispatcher

if (isset($_GET['all'])) {                  // Show all subs
	$option = 2;
} elseif (isset($_GET['random'])) {         // Show random sub
	$sub = SitesMgr::get_random_sub();
	$url = 'https://'.get_server_name().$sub->base_url.'tema/'.$sub->name;
	redirect(html_entity_decode($url), 307);
	exit(0);
} elseif (! $current_user->user_id || isset($_GET['active']))  {    // Show active
	$option = 1;
} elseif (isset($_GET['subscribed'])) {     // Show suscribed
	$option = 0;
} else {
	$option = count(SitesMgr::get_subscriptions($current_user->user_id)) > 0 ? 0 : 1;
}

$char_selected = $chars = false; // User for index by first letter


do_header(_("temas factocheck"), 'temas', false, $option, '', false);


/*** SIDEBAR ****/
/*
echo '<div id="sidebar">';
do_banner_right();
do_banner_promotions();
echo '</div>';
*/
/*** END SIDEBAR ***/

echo '<div>';
echo '<div id="newswrap" class="col-sm-9">';
echo '<div class="row">';

switch ($option) {
	case 0:
		$subs = SitesMgr::get_subscriptions($current_user->user_id);
		$template = 'subs_simple.html';
		$all = false;
		break;
	case 1:
		$all = false;
		$template = 'subs.html';
		$subs = SitesMgr::get_subs_active();
		break;
	default:
		$all = true;
		$chars = $db->get_col("select distinct(left(ucase(name), 1)) from subs");

		// Check if we must show just those beginning with a letter
		if (!empty($_GET['c']) && 
			($char_selected = substr(clean_input_string($_GET['c']), 0, 1)) ) {
			$extra = "subs.name like '$char_selected%' and";
			$rows = $db->get_var("select count(*) from subs where $extra subs.sub = 1 and created_from = ".SitesMgr::my_id());
		} else { 
			$extra = '';
			$rows = -1;
		}

		$template = 'subs.html';
		$page_size = 50;
		$page = get_current_page();
		$offset=($page-1)*$page_size;

		$sql = "select subs.*, user_id, user_login, user_avatar from subs, users where $extra subs.sub = 1 and created_from = ".SitesMgr::my_id()." and user_id = owner order by name asc limit $offset, $page_size";
		$subs = $db->get_results($sql);
}

$all_subs = $db->get_results($sql);
$subs_followers_counter = $db->get_results("select subs.id, count(*) as c from subs, prefs where pref_key = 'sub_follow' and subs.id = pref_value group by subs.id order by c desc;");

$subs = array();
foreach ($all_subs as $s) {
	foreach ($subs_followers_counter as $sub_counter) {
		if ($s->id == $sub_counter->id) {
			$s->followers = $sub_counter->c;
		}
	}
	if (!isset($s->followers)) $s->followers=0;
	if ($s->enabled) {
		$subs[] = $s;
	}
}

Haanga::Load($template, compact('title', 'subs', 'chars', 'char_selected'));

echo '</div>';

if ($all) {
	do_pages($rows, $page_size, true);
}

echo '</div></div>';

do_footer();

function print_tabs($option) {
	global $current_user;

	//if (SitesMgr::my_id() == 1 && SitesMgr::can_edit(0)) $can_edit = true;
	//else $can_edit = false;

	$items = array();
	
	if ($current_user->user_id) {
		$suscriptions_num = count(SitesMgr::get_subscriptions($current_user->user_id));
		$items[] = array('id' => 0, 'url' => 'subs?subscribed', 'title' => _('suscripciones')." [$suscriptions_num]");
	}
	$items[] = array('id' => 1, 'url' => 'subs?active', 'title' => _('más activos'));
	$items[] = array('id' => 2, 'url' => 'subs?all', 'title' => _('todos'));
	//if ($can_edit) {
		$items[] = array('id' => 3, 'url' => 'subedit', 'title' => _('crear sub'));
	//}

	$vars = compact('items', 'option');
	return Haanga::Load('print_tabs.html', $vars);
}


