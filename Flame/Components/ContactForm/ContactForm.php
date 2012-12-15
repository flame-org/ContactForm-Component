<?php
/**
 * ContactForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Brutal
 *
 * @date    25.11.12
 */

namespace Flame\Components\ContactForm;

class ContactForm extends \Brutal\Application\UI\Form
{

	public function __construct()
	{
		parent::__construct();

		$this->addExtension('addAntiSpam', '\Flame\Forms\Controls\AntiSpamControl');

		$this->configure();
	}

	private function configure()
	{

		$this->addAntiSpam('spam');

		$this->addSelect('city', 'Město', array('Praha', 'Ústí nad Lebem', 'Liberec'))
			->setRequired();

		$this->addText('name', 'Jméno')
			->setRequired();

		$this->addText('email', 'Váš email')
			->setType('email')
			->addRule(self::EMAIL)
			->addRule(self::FILLED);

		$this->addText('subject', 'Předmět')
			->setRequired();

		$this->addTextArea('message', 'Zpráva')
			->setRequired();

		$this->addSubmit('send', 'Odeslat')
			->setAttribute('class', 'btn-primary');
	}

}