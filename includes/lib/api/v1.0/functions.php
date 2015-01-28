<?php
function lookup(array $params) 
{
	$db = Database::getInstance();
	$sql = 'SELECT gplus, facebook, twitter, instagram
	FROM ci_users
	WHERE' + $params['socialmedia'] + '=' + $params['userid'];
	$queryResult = $db->exec($sql);
	if ($queryResult === false or $queryResult === true)
	{
		http_response_code(400);
		print 'an error occurred: check if your request was valid';
	} else
	{
		for (i = 0; i < 4; i++)
		{
			if ($params['socialmedia'] != columnToSocialmedia($i))
			{
				$result[] = ('socialmedium' => columnToSocialmedia($i), 'userid' => $queryResult[0][$i]);
			}
		}
		header('Content-type: application/json');
		print json_encode($result);
	}
}

function friendsuggest(array $params) 
{
	$db = Database::getInstance();
	$sql = 'SELECT
	FROM
	WHERE
	'
	$queryResult = $db->exec($sql);
	header('Content-type: application/json');
	print json_encode($queryResult);
}

function columnToSocialmedia($num)
{
	$socialMedia = array (gplus, facebook, twitter, instagram);
	return $socialMedia[$num];
}

function socialMediaToNum($socialMedia)
{
	$reference = array ('gplus' => 0, 'facebook' => 1, 'twitter' => 2, 'instagram' => 3);
	return $reference[$socialMedia];
}
?>