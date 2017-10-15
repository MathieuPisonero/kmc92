<?php 

namespace Kmc\Bundle\AdminBundle\Utils\Content;

use Kmc\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\File\File;

class Content
{
	private $container;
	
	private $em;
	
	private $file;
	
	private $user;
	
	private $isAuthenticated;
	
	private $contextList;
	
	private $validExtensions;
	
	private $errors;
		
	public function __construct(ContainerInterface $container, EntityManager $em, TokenStorage $security)
	{
		$this->container = $container;
		$this->em = $em;
		$this->user = $security->getToken()->getUser();
		$this->isAuthenticated = $security->getToken()->isAuthenticated();
		$this->valid_extensions = array("jpg","jpeg","png","gif");
		$this->contextList = array(	"club_logo"=>"getLogo",
								   	"tmp"=>false,
								   	"defaut"=>false);
		$this->errors = array();
	}
	
	public function getFile()
	{
		return $this->file;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function getIsAuthenticated()
	{
		return $this->user;
	}
	
	public function getValidExtensions()
	{
		return $this->validExtensions;
	}
	
	public function getContextList()
	{
		return $this->contextList;
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	protected function genFileName(UploadedFile $fileObject)
	{
		$filename = \md5(\time().$fileObject->getClientOriginalName()) . '.' . $fileObject->guessExtension();
		return $filename;
	}
	
	protected function genPath($context)
	{
		$upload_dir = $this->container->getParameter('kmc_admin.image.directory');
		$context_parameter = 'kmc_admin.image.' . $context . '.directory';
		if($this->container->hasParameter($context_parameter))
			$context_dir = $this->container->getParameter($context_parameter);
		else
			die('error contexte');
		
		$path = $upload_dir . "/" . $context_dir;
		
		$fs = new Filesystem();
		if(!$fs->exists($path))
		{
			$fs->mkdir($path);
		}
		return ($path);
		
	}
	
	protected function validateExtension($extension)
	{
		if( in_array($extension,$this->valid_extensions) )
			return true;
		else
			return false;
	}
	
	protected function validateContext($context)
	{
		if( array_key_exists ($context,$this->contextList) )
			return true;
		else
			return false;
				
	}
	
	protected function getError()
	{
		$error = false;
		$tmp = array("errors"=>array());
		foreach ($this->errors as $key=>$value)
		{
			if( !$value)
			{
				$error["errors"][]= $key;
			}
		}
		return $error;
	}
	
}