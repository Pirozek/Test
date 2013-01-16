<?php

/**
 * Base presenter for all application presenters.
 */

abstract class BasePresenter extends Nette\Application\UI\Presenter {

	/** @persistent */
	public $backlink = '';

	protected function startup() {
		parent::startup();
		
		$this->template->title = "Ordinace v Kutne Hore";
	}

}

