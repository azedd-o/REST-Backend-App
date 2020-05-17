<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Classes\Language;

class LanguageController extends AbstractController
{
    /**
     * @Route("/", name="language")
     */
    public function index()
    {
        
		//set UserAgent header
		$opts = [
				'http' => [
						'method' => 'GET',
						'header' => [
								'User-Agent: PHP'
						]
				]
		];

		$context = stream_context_create($opts);


		// set the last 30 days date 
		$date = date("Y-m-d", strtotime("-30 days"));



		//set api url
		$url= 'https://api.github.com/search/repositories?q=created:>'.$date.'&per_page=100&sort=stars&order=desc';


		//call api
		$query = file_get_contents($url, false, $context);
		$query = json_decode($query);

		
		$languages = array();


		foreach($query->items as $element)
		{
			
				
				//delete undefined repositories with undefined languages (null);
					
					if($element->language!=Null)
					{
						$lang = new Language();
						$lang->setName($element->language);
						array_push($languages,$lang);
					}
				
			
		}
		
		
        //delete redundant languages from array
		$languages=(array_unique($languages, SORT_REGULAR));



		foreach($languages as $ln)
		{
			
				
			foreach($query->items as $element)
			{
				
				
				if($ln->getName()==$element->language)
				{
					
					$listRepos = $ln->getListRepos();
					
					array_push($listRepos,$element->full_name);
					$ln->setListRepos($listRepos);
					$ln->setNbRepos(count($listRepos));

					
				}
			}
				
			
		}

        //Sort array by number of repositories
		usort($languages, 'compare'); 
		
        //Parse json response
        foreach($languages as $lang)
		{
			$JSONarray[] = array(
				'Language' => $lang->getName(),
				'NbRepos' => $lang->getNbRepos(),
				'Repositories' => $lang->getListRepos(),
				
			);
		}

		
		//Return json response
		$response = new Response();
		$response->setContent(json_encode([
			$JSONarray,
		],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
		$response->headers->set('Content-Type', 'application/json');
		

		return $response;


		
    }
	
}
