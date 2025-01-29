<?php
class Controller_Home extends Controller
{
	private $errors = [];
	private $messages = [];
	private $roles = [];

	function createPage(string $viewName)
	{
		$this->roles = $this->model->getUserRole();
		$this->view->generate($viewName, 'default.php', $this->authorised, null, null, null, $this->roles);
	}
}
