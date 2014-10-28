<?php
/**
*
* @package phpBB Extension - ELONW
* @copyright (c) 2014 Rich McGirr
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\elonw\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var \phpbb\template\template */
	protected $template;

	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_footer_after'	=> 'elonw_inject',
		);
	}

	public function elonw_inject($event)
	{

		// Output to the template
		$this->template->assign_vars(array(
			'S_ELONW'			=> true,
		));
	}
}
