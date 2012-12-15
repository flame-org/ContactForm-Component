<?php
/**
 * IContactFormFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package
 *
 * @date    25.11.12
 */

namespace Flame\Components\ContactForm;

interface IContactFormFactory
{

	/**
	 * @return ContactForm
	 */
	public function create();

}
