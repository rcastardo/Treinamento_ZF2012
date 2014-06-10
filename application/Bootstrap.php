<?php
//apenas controller acessam esta classe
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	//executa automaticamente
	public function _initSession()
	{
		Zend_Session::start();
		$form = new Zend_Session_Namespace('form');
		Zend_Registry::set('form', $form);
		
		$seg = new Zend_Session_Namespace('seg');
		Zend_Registry::set('seg', $seg);
	}
	
	public function _initTranslator()
	{
		$translate = new Zend_Translate(
				array(
					'adapter' => 'Array',//classe zend
					'content' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 
					'resources' . DIRECTORY_SEPARATOR . 'languages',
					'locale' => 'pt_BR',
					'scan' => Zend_Translate::LOCALE_DIRECTORY 		
				)
		);
		
		Zend_Validate::setDefaultTranslator($translate);
	}
	
	public function _initNamespace()
	{
		Zend_Loader_Autoloader::getInstance()->registerNamespace('Anhanguera');
	}
	
	public function _initLocale()
	{
		$locale = new Zend_Locale('en_US');
		Zend_Registry::set('Zend_Locale', $locale);	
	}
	
	public function _initRouter()
	{//http://localhost/bueno/servicos/financeiro/obter-taxa/referencia/23
		$router = Zend_Controller_Front::getInstance()->getRouter();
		
		$route = new Zend_Controller_Router_Route(
			'xml-rpc' /*entrada*/,
			array('module' => 'default',
				'controller' => 'xml-rpc',
				'action' => 'index' 	
			) 
		);
		$router->addRoute('xml-rpc', $route);	

		//para desativar o 'ultimo parametro
		//Zend_Controller_Router_Route_Regex()
		
		//servicos/financeiro/obter-taxa/referencia/:r
		$route = new Zend_Controller_Router_Route(
			'taxa/:referencia/:regiao' /* entrada /:param */,
			array('module' => 'servicos',
				'controller' => 'financeiro',
				'action' => 'obter-taxa' 	
			) 
		);
		$router->addRoute('taxa', $route);						
	}
	
	public function _initView()
	{
		$view = new Anhanguera_View();
		Zend_Registry::set('view', $view);
	}
	
	public function _initLog()
	{
		$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/log/debug.log');
		$log = new Zend_Log($writer);
		Zend_Registry::set('log', $log);
	}
	
}



