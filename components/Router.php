<?php

namespace components;

class Router
{
	private $router;

	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->router = include($routesPath);
	}

	public function run()
	{
		$uri = $this->getUri();

		foreach ($this->router as $uriPattern => $path) {
			if (preg_match('~^$uriPattern$~', $uri)) {

				$internalRoute = preg_replace('~$uriPattern~', $path, $uri);

				$segments = explode('/', $internalRoute);
				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action'.ucfirst(array_shift($segments));

				$isGet = strpos(implode($segments), '?');
				if ($isGet === false) {
					$parameters = $segments;
				} else {
					$parameters = [];
				}

				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}

				$controllerObject = new $controllerName;
				$result = call_user_func_array([$controllerObject, $actionName], $parameters);

				if ($result != null) {
					break;
				}
			}
		}
	}

	private function getUri()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}
}