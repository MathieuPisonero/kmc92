<?php 

namespace Kmc\Bundle\AdminBundle\Utils\Content;

use Kmc\Bundle\AdminBundle\Utils\Content\Content;
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

class ContentDownload extends Content
{	
	public function __construct(ContainerInterface $container, EntityManager $em, TokenStorage $security)
	{
		parent::__construct($container, $em, $security);
	}
	
	public function getPathFile($filename,$context){
		$path = $this->genPath($context);
		return ($path.'/'.$filename);
	}
	
	public function getDwLFilePath(Request $request, $context){
		if(!$this->hasTMPDwlFile($request))
			return false;
		
		$attribute = $request->request->get('attribute_image');
		$filename = $request->request->get('image_name');
		
		$path = $this->getPathFile($filename,'tmp');
		
		$fs = new Filesystem();
		if($fs->exists($path))
		{
			$file = new File($this->getPathFile($filename,'tmp'));
			$new_path = $this->genPath($context);
			$file->move( $new_path, $filename );
			return($new_path.'/'.$filename);
		}
		return (false);
		 
	}
	
	//Construction de l'URL pour le content download
	public function getUrlImageAlias($obj, $context){
		
		//Si pas d'id (nvx objet, donc pas d'image) renvois false
		if(empty($obj->getId()))
			return false;
		
		//verification de l'utilisateur
		if( !$this->checkOwner($obj))
			return "false";
		
		//Valide que le context de l'image est valide
		if( !$this->validateContext($context))
			return false;
			
		//récupération du getter image de l'objet
		$method = $this->getContextList()[$context];
		if( !method_exists($obj, $method) )
			return false;
		
		//Récupération du path de l'image (valeur de l'attribut image de l'objet)
		$file_path = $obj->$method();
		//Vérifiction que l'image existe
		if(empty($file_path))
			return false;

		//Création d'un objet file, pour récupérer le nom du fichier (image)
		$file = new File($file_path);
		if(!$file)
			return false;
		
		//Set de l'url alias d'une image
		$url_alias = "http://orgak.dev/app_dev.php/contentdownload/".$context."/".$file->getFilename();
		return $url_alias;
		
	}
	
	private function checkOwner($obj){
		if(!(method_exists($obj,'getUser')))
			return false;
		if($this->getUser()->getId() == $obj->getUser()->getId())
			return true;
		return false;
	}
	
	private function hasTMPDwlFile(Request $request)
	{
		if($request->request->has('attribute_image') && $request->request->has('image_name'))
			return true;
		else
			return false;
	}
}