<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 Purdue University. All rights reserved.
 *
 * This file is part of: The HUBzero(R) Platform for Scientific Collaboration
 *
 * The HUBzero(R) Platform for Scientific Collaboration (HUBzero) is free
 * software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * HUBzero is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @author    Shawn Rice <zooley@purdue.edu>
 * @copyright Copyright 2005-2015 Purdue University. All rights reserved.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

// no direct access
defined('_HZEXEC_') or die();

if ($this->getError())
{
	echo '<p class="error">' . Lang::txt('MOD_MYMESSAGES_ERROR') . '</p>' . "\n";
}
else
{
	// Push the module CSS to the template
	$this->css();
	?>
	<div<?php echo ($this->moduleclass) ? ' class="' . $this->moduleclass . '"' : ''; ?>>
		<ul class="module-nav">
			<li><a class="icon-email-alt" href="<?php echo Route::url('index.php?option=com_members&id=' . User::get('id') . '&active=messages'); ?>"><?php echo Lang::txt('MOD_MYMESSAGES_ALL_MESSAGES'); ?></a></li>
			<li><a class="icon-plus" href="<?php echo Route::url('index.php?option=com_members&id=' . User::get('id') . '&active=messages&task=settings'); ?>"><?php echo Lang::txt('MOD_MYMESSAGES_MESSAGE_SETTINGS'); ?></a></li>
		</ul>

		<?php if (count($this->rows) <= 0) { ?>
			<p><em><?php echo Lang::txt('MOD_MYMESSAGES_NO_MESSAGES'); ?></em></p>
		<?php } else { ?>
			<ul class="expandedlist">
				<?php
				foreach ($this->rows as $row)
				{
					$cls = 'box';
					if ($row->actionid)
					{
						$cls = 'actionitem';
					}
					if ($row->component == 'support' || $row->component == 'com_support')
					{
						$fg = explode(' ', $row->subject);
						$fh = array_pop($fg);
						$row->subject = implode(' ', $fg);
					}
					?>
					<li class="<?php echo $cls; ?>">
						<a href="<?php echo Route::url('index.php?option=com_members&id=' . User::get('id') . '&active=messages&msg=' . $row->id); ?>">
							<?php echo $this->escape(stripslashes($row->subject)); ?>
						</a>
						<span>
							<span>
								<time datetime="<?php echo $this->escape($row->created); ?>"><?php echo Date::of($row->created)->toLocal(Lang::txt('DATE_FORMAT_HZ1')); ?></time>
							</span>
						</span>
					</li>
					<?php
				}
				?>
			</ul>
		<?php } ?>
		<?php if ($this->total > $this->limit) { ?>
			<p class="note"><?php echo Lang::txt('MOD_MYMESSAGES_YOU_HAVE_MORE', $this->limit, $this->total, Route::url('index.php?option=com_members&id=' . User::get('id') . '&active=messages')); ?></p>
		<?php } ?>
	</div>
	<?php
}