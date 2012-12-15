#ContactForm-Component

**Nette component for sending emails from your web page**

##Usage

**Presenter**
```php
class ContactPresenter extends BasePresenter
{

	/**
	 * @var \Flame\Components\ContactForm\IContactFormFactory $contactFormFactory
	 */
	private $contactFormFactory;

	/**
	 * @param \Flame\Components\ContactForm\IContactFormFactory $contactFormFactory
	 */
	public function injectContactFormFactory(\Flame\Components\ContactForm\IContactFormFactory $contactFormFactory)
	{
		$this->contactFormFactory = $contactFormFactory;
	}

	/**
	 * @return Flame\Components\ContactForm\ContactForm
	 */
	public function createComponentContactForm()
	{
		$form = $this->contactFormFactory->create();
		$form->setRenderer(new \Kdyby\Extension\Forms\BootstrapRenderer\BootstrapRenderer);
		$form->onSuccess[] = $this->lazyLink('default');
		return $form;
	}

}
```

**Config**

	services:
		ContactFormProcess: \Flame\Components\ContactForm\ContactFormProcess(support@email.cz)

	factories:
		contactForm:
			implement: \Flame\Components\ContactForm\IContactFormFactory