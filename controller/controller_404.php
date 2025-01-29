<?php
class Controller_Authorisation extends Controller
{
	function createPage(string $viewName)
	{
		$this->view->generate($viewName, 'default.php', $this->authorised);
	}
}
