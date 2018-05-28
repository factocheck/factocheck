<?php
// The Meneame source code is Free Software, Copyright (C) 2005-2009 by
// Ricardo Galli <gallir at gmail dot com> and Menéame Comunicacions S.L.
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.

// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('config.php');
include(mnminclude.'html1.php');

meta_get_current();

$globals['ads_section'] = 'portada';
$pagetitle = $globals['site_name'];

do_header($pagetitle, _('portada'), false, 0);

Haanga::Load('site_search_box.html'); // Search box for search engines

echo '<div>';
echo '<div id="newswrap" class="col-sm-9">';
echo '<div class="row">';

/* Hot */
echo '<h2 class="index-header">'._('Destacadas').'</h2>';

echo '<div>';
/* hot false */
$idl = $db->get_var("select * from links, sub_statuses
		where sub_statuses.id = ".$globals['site_id']." and status = 'published' and date > date_sub(now(), interval ".$globals['hot_interval']." day) and link = link_id order by link_negatives desc limit 1");
$link = Link::from_db($idl);

if ($link) {
	$link->max_len = 600;
	echo '<div class="col-lg-6 col-sm-6 col-12 news-summary-height topnewsf">';
	$link->print_summary('topnews');
	echo '</div>';
}

/* hot true */
$idl = $db->get_var("select * from links, sub_statuses
		where sub_statuses.id = ".$globals['site_id']." and status = 'published' and date > date_sub(now(), interval ".$globals['hot_interval']." day) and link = link_id order by link_votes desc limit 1");
$link = Link::from_db($idl);

if ($link) {
	$link->max_len = 600;
	echo '<div class="col-lg-6 col-sm-6 col-12 news-summary-height topnewst">';
	$link->print_summary('topnews');
	echo '</div>';
}

echo '</div></div>'; /* end row hot news */


/* Trending */
echo '<div class="row">';
echo '<a href="//'.$globals['server_name'].$globals['base_url'].'trending"><h2 class="index-header divisor">'._('Tendencias').'</h2></a>';

$order_by = "ORDER BY sub_date DESC ";
$where = "sub_statuses.id = ". $globals['site_id'] ." AND status='published' ";
$trending_size = $globals['trending_size'];
$sql = "SELECT".Link::SQL."INNER JOIN (SELECT link FROM sub_statuses $from WHERE $where) as ids ON (ids.link = link_id) $order_by LIMIT 0,$trending_size";

// Search for sponsored link
//if (!empty($globals['sponsored_link_uri'])) $sponsored_link = Link::from_db($globals['sponsored_link_uri'], 'uri');

$links = $db->object_iterator($sql, "Link");

if ($links) {
	$counter = 0;
	foreach($links as $link) {
		// Skip print link if is already printed as top highlight
		//if( isset($top) && ($top->id == $link->id) ) {
		//	continue;
		//}

		$link->max_len = 600;
		$link->print_summary('frontpage');
		$counter++;
		//Haanga::Safe_Load('private/ad-interlinks.html', compact('counter', 'page_size', 'sponsored_link'));
	}
}

echo '</div>'; /* end row trending news */




/* New */
echo '<div class="row">';
echo '<a href="//'.$globals['server_name'].$globals['base_url'].'new"><h2 class="index-header divisor">'._('Novedades').'</h2></a>';

$order_by = "ORDER BY sub_date DESC";
$where = "sub_statuses.id = ". $globals['site_id'] ." AND status='queued' ";
$new_size = $globals['new_size'];

$sql = "SELECT".Link::SQL."INNER JOIN (SELECT link FROM sub_statuses WHERE $where) as ids on (ids.link = link_id) $order_by LIMIT 0,$new_size";
$links = $db->object_iterator($sql, "Link");

if ($links) {
	foreach($links as $link) {
		//if ($link->status == 'draft' && $link->author != $current_user->user_id) continue;
		$link->max_len = 600;
		$link->print_summary('full', 16);
		/*
		if ($offset < 1000) {
			$link->print_summary('full', 16);
		} else {
			$link->print_summary('full');
		}*/
	}
}

echo '</div>';  /* end row new news */
//do_pages($rows, $page_size);
echo '</div>';  /* end newswrap */



/*** SIDEBAR ****/
echo '<div id="sidebar" class="col-sm-3">';
do_sub_message_right();
do_banner_right();
if ($globals['show_popular_published']) {
	do_active_stories();
}
// do_banner_promotions();
if ($globals['show_popular_published']) {
	do_most_clicked_stories();
	do_best_stories();
}
do_banner_promotions();
// do_best_sites();
do_most_clicked_sites();
do_best_comments();
//do_last_subs('published');
//do_vertical_tags('published');
// do_last_blogs();
echo '</div>';
/*** END SIDEBAR ***/

echo '</div>';


do_footer();
exit(0);

