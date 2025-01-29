<?php
class Controller
{
	public $model;
	public $view;
	public $authorised = false;

	function __construct()
	{
		$this->model = new Model();
		$this->authorised = $this->checkAuth();
		$this->view = new View();
	}

	function checkAuth()
	{
		$result = $this->model->checkUser();
		if (is_null($result)) {
			return false;
		} else {
			return true;
		}
	}
}
