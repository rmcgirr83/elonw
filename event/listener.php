<?php
/**
*
* @package External Links Open in New Window
* @copyright (c) 2014 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\elonw\event;

use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\language\language 	$language	Language object
	* @param \phpbb\request\request 	$request	Request object
	* @param \phpbb\template\template 	$template	Template object
	* @param \phpbb\user 				$user		User object
	* @return \rmcgirr83\elonw\event\listener
	* @access public
	*/
	public function __construct(language $language, request $request, template $template, user $user)
	{
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'user_setup',
			'core.page_header' 						=> 'main',
			'core.ucp_prefs_personal_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_personal_update_data'	=> 'ucp_prefs_set_data',
		);
	}

	public function user_setup($event)
	{
		$this->language->add_lang('common', 'rmcgirr83/elonw');
	}

	public function main($event)
	{
		$this->template->assign_vars(array(
			'S_ELONW'	=>	!empty($this->user->data['user_elonw']) ? true : false,
		));
	}

	/**
	* Get user's option and display it in UCP Prefs View page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function ucp_prefs_get_data($event)
	{
		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], array(
			'elonw'	=> $this->request->variable('elonw', (int) $this->user->data['user_elonw']),
		));

		// Output the data vars to the template (except on form submit)
		if (!$event['submit'])
		{
			$this->language->add_lang('elonw_ucp', 'rmcgirr83/elonw');
			$this->template->assign_vars(array(
				'S_UCP_ELONW'	=> $event['data']['elonw'],
			));
		}
	}

	/**
	* Add user's elonw option state into the sql_array
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'user_elonw' => $event['data']['elonw'],
		));
	}
}
