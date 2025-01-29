<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;

class Controller_Login extends Controller
{
	private string $token;
	private $log;
	private $VKparams = array();

	function __construct()
	{
		require_once 'model/model_login.php';
		$this->model = new Model_Login();
		$this->token = hash('gost-crypto', random_int(100000, 999999));
		$_SESSION["CSRF"] = $token;
		$this->view = new View();
		$this->log = new Logger('mylogger');
		// пишем логи в "mylog.log"
		$this->log->pushHandler(new StreamHandler('mylog.log', Logger::WARNING));
		// пишем логи в "troubles.log" с ошибками уровня Alert
		$this->log->pushHandler(new StreamHandler('troubles.log', Logger::ALERT));
		$this->VKparams = array(
			'client_id'     => VK_CLIENT_ID,
			'redirect_uri'  => VK_REDIRECT_URI,
			'response_type' => 'code'
		);
	}

	function createPage(string $viewName)
	{
		$this->view->generate($viewName, 'default.php', $this->authorised, null, null, $this->token, null, $this->VKparams);
	}

	// генерируем случайную строку
	function generateCode($length = 6)
	{
		$chars = "7dd948c5b8e2207fbdec46c95a0cce8f a5e729f1d9caa099cde616806311a90f";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length) {
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}

	function submitted()
	{
		if ($_POST["token"] == $_SESSION["CSRF"]) {
			$ip = '';
			$hash = md5($this->generateCode(10));
			$login = $this->model->getUser($_POST['login'], md5(md5($_POST['password'])), $hash, str_replace('.', '', $_SERVER['REMOTE_ADDR']), $ip);
			if ($login) {
				setcookie("id", $login, time() + 60 * 60 * 24 * 30, "/");
				setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true);
				header("Location: /index.php?page=3");
			} else {
				$this->log->warning('Попытка неудачной авторизации');
			}
		} else {
			$this->log->warning('Нас пытаются взломать!!!');
		}
	}

	public function vkAuth()
	{
		if (isset($_GET['code'])) {
			$params = array(
				'client_id' => VK_CLIENT_ID,
				'client_secret' => VK_CLIENT_SECRET,
				'code' => $_GET['code'],
				'redirect_uri' => VK_REDIRECT_URI
			);
			$token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
			if (isset($token['access_token'])) {
				$params = array(
					'uids'         => $token['user_id'],
					'v'            => '5.126',
					'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate',
					'access_token' => $token['access_token']
				);

				$userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
				if (isset($userInfo['response'][0]['id'])) {
					$userInfo = $userInfo['response'][0];
					$result = true;
				}
				if ($result) {
					if ($_POST["token"] == $_SESSION["CSRF"]) {
						//пользователь уже есть    
						if ($login) {
							$ip = '';
							$hash = md5($this->generateCode(10));
							$login = $this->model->getUser($userInfo['id'], md5(md5($userInfo['id'] . $userInfo['first_name'] . $userInfo['sex'])), $hash, str_replace('.', '', $_SERVER['REMOTE_ADDR']), $ip, 1);
							if ($login) {
								setcookie("id", $login, time() + 60 * 60 * 24 * 30, "/");
								setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true);
								header("Location: /index.php?page=3");
							} else {
								$this->log->warning('Попытка неудачной авторизации');
							}
							header("Location: /index.php?page=3");
						}
						//создаём нового пользователя       
						else {
							$this->model->createUser($userInfo['id'], $userInfo['id'] . $userInfo['first_name'] . $userInfo['sex'], 2);
							$ip = '';
							$hash = md5($this->generateCode(10));
							$login = $this->model->getUser($userInfo['id'], md5(md5($userInfo['id'] . $userInfo['first_name'] . $userInfo['sex'])), $hash, str_replace('.', '', $_SERVER['REMOTE_ADDR']), $ip, 1);
							if ($login) {
								setcookie("id", $login, time() + 60 * 60 * 24 * 30, "/");
								setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true);
								header("Location: /index.php?page=3");
							} else {
								$this->log->warning('Попытка неудачной авторизации');
							}
							header("Location: /index.php?page=3");
						}
					} else {
						$this->log->warning('Мошенник пытается вломиться!');
					}
				}
			}
		}
	}
}
