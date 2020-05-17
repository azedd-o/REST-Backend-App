<?php


function compare($a, $b) 
{
	return count($a->getListRepos()) < count($b->getListRepos()); 
}


?>