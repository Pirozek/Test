<?php

/**
 * Home presenter.
 */
class HomePresenter extends BasePresenter {

	protected function startup() {
		parent::startup();
		$this->redirect('Calendar:default');
	}

}
