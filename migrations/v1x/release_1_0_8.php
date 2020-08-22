<?php
/**
*
* @package External Links Open in New Window
* @copyright (c) 2020 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\elonw\migrations\v1x;

class release_1_0_8 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !isset($this->config['elonw_version']);
	}

	static public function depends_on()
	{
		return ['\rmcgirr83\elonw\migrations\v1x\release_1_0_1'];
	}

	public function update_data()
	{
		return [
			['config.remove', ['elonw_version']],
		];
	}
}
