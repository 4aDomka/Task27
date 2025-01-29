<?php
class Controller_Unlogin extends Controller
{
	function __construct()
	{
		$this->model = new Model();
		$this->unlogin();
	}

	function unlogin()
	{
		$result = $this->model->checkUser();
		if (!is_null($result)) {
			setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
			setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/", null, null, true);
			header("Location: /index.php?page=1");
		}
	}
}
