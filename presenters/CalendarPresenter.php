<?php

use Nette\Application\UI\Form;

class CalendarPresenter extends BasePresenter {

	protected function startup() {
		parent::startup();
		$this->template->title = "Kalendář";
	}

	private $calendarModel;
    
    public function injectModels(models\Calendar $calendarModel) {
        $this->calendarModel = $calendarModel;
    }

    public function actionUserEvents($start, $end, $ordinace)
    {
       	$res = $this->calendarModel->getEventsCalendar($start,$end,$ordinace)->setType('start',Dibi::TEXT)->setType('end',Dibi::TEXT);

    	$this->payload->events = json_encode($res->fetchAll());

    	$response = new \Nette\Application\Responses\JsonResponse($res->fetchAll());
		$this->sendResponse($response);
		//asdasd
    }

    public function actionZobrazOrdinaci($id)
    {
        $this->template->ordinace = $id;
        $this['addEvent']['ordinace']->setDefaultValue($id);
    }

    protected function createComponentAddEvent() 
    {
        $form = new Form($this, 'addEvent');
        $form->addText('title', 'Název*')->setRequired('Vyplňte název');
        $form->addText('start', 'Od*')->setRequired('Vyplňte od kdy')->setAttribute('class','datepicker')->setAttribute('size','20');
        $form->addText('end', 'Do*')->setRequired('Vyplňte do kdy')->setAttribute('class','datepicker2')->setAttribute('size','20');
        $form->addSubmit('submit', 'Vložit záznam');
        $form->addHidden('ordinace');
        $form->onSuccess[] = callback($this, 'addEventSubmited');
        return $form;
    }

    public function addEventSubmited($form) 
    {
        $val = $form->getValues();

        $this->calendarModel->addEvent($val);

        $this->flashMessage('Schůzka úspěšně přidána');
        $this->redirect('Calendar:ZobrazOrdinaci',$val->ordinace);
    }
}

?>