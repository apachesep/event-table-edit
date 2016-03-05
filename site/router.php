<?php
/**
 * $Id: $
 * @copyright (C) 2007 - 2010 Manuel Kaspar
 * @license GNU/GPL, see LICENSE.php in the installation package
 * This file is part of Event Table Edit
 *
 * Event Table Edit is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Event Table Edit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Event Table Edit. If not, see <http://www.gnu.org/licenses/>.
 */
 
function EventTableEditBuildRoute(&$query)
{
	$segments = array();
	
	// get a menu item based on Itemid or currently active
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	} else {
		$menuItem = $menu->getItem($query['Itemid']);
	}
	
	if (isset($query['view']))
	{
		if ($query['view'] != 'etetable' || !isset($menuItem)) {
			$segments[] = $query['view'];
		}
		unset($query['view']);
	}

	if (isset($query['id'])) {
		if (!isset($menuItem)) {
			$segments[] = $query['id'];
		}
		unset($query['id']);
	}

	return $segments;
}

function EventTableEditParseRoute($segments)
{
	$vars = array();
	
	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
 
	//Handle View and Identifier
	switch($segments[0])
	{
		case 'changetable':
		{
			$vars['view'] = 'changetable';
			
			if (!isset($item)) {
				$val = explode(':', $segments[1]);
				$vars['id'] = $val[0];
			} else {
				$vars['id'] = $item->params->get('tablenumber');
			}
		} break;
		case 'etetable':
		case 'eventtableedit':
		{
			$vars['view'] = 'etetable';
		} break;
	}

	return $vars;
}
