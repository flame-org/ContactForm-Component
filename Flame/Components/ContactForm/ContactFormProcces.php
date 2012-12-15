<?php
/**
 * ContactFormProcces.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Brutal
 *
 * @date    25.11.12
 */

namespace Flame\Components\ContactForm;

class ContactFormProcces extends \Nette\Object
{

	/**
	 * @var array
	 */
	private $cityEmails = array(
		'praha@brutalkruhac.cz', 'ustinl@brutalkruhac.cz', 'liberec@brutalkruhac.cz'
	);

	/**
	 * @var \Nette\Templating\FileTemplate $this->fileTemplate
	 */
	private $fileTemplate;

	/**
	 * @var \Nette\Mail\SmtpMailer $mailer
	 */
	private $mailer;

	/**
	 * @param \Nette\Mail\SmtpMailer $mailer
	 */
	public function injectMailer(\Nette\Mail\SmtpMailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @param \Nette\Templating\FileTemplate $fileTemplate
	 */
	public function injectFileTemplate(\Nette\Templating\FileTemplate $fileTemplate)
	{
		$this->fileTemplate = $fileTemplate;
	}

	/**
	 * @param ContactForm $form
	 */
	public function send(ContactForm $form)
	{
		$values = $form->getValues();

		if($values->spam != 'nospam'){
			$form->addError('Prosím vyplňte antispamovou ochranu');
			return;
		}

		if(!isset($this->cityEmails[$values->city])){
			$form->addError('Vybrali jste nepovolené město!');
			return;
		}

		$this->fileTemplate->setFile(__DIR__ . '/MailBodyTemplate.latte');
		$this->fileTemplate->registerFilter(\Nette\Callback::create(new \Nette\Latte\Engine()));
		$this->fileTemplate->name = $values->name;
		$this->fileTemplate->email = $values->email;
		$this->fileTemplate->text = $values->message;

		$toEmail = $this->cityEmails[$values->city];

		try {
			$message = new \Nette\Mail\Message();
			$message->setSubject($values->subject)
				->setFrom($values->email, $values->name)
				->addTo($toEmail, $toEmail)
				->setHtmlBody($this->fileTemplate);

			$this->mailer->send($message);
			$form->presenter->flashMessage('Email byl odeslán, děkujeme.', 'success');

		}catch (\Exception $ex){
			$form->presenter->flashMessage('Email se nepodařilo odeslat, prosím zkuste to znovu.');
		}
	}

}
