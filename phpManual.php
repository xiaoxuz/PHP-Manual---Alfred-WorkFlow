<?php 
	include("workflows.php");
	include("funcList.php");

	$keyWord     = $argv[1];

	$objWorkFlow = new Workflows();

	$funcData = array();

	$limit = 20;

	//完全匹配
	if(isset($funcList[$keyWord])) {
		$funcData[$keyWord] = $funcList[$keyWord];
	}
		
	//模糊匹配
	foreach($funcList as $key=>$val) {

		if (count($funcData) >= $limit) {
	        break;
	    }

		if(strpos($key, $keyWord) !== false) {
			$funcData[$key] = $val;
		}
	}

	// 拆词匹配
	foreach ($funcList as $funcName => $val) {
	    if (count($funcData) >= $limit) {
	        break;
	    }
	    
	    $kwList = preg_split("/[\_\-\ ]/", $keyWord);
	    foreach ($kwList as $kwItem) {
	        if (strpos($funcName, $kwItem) === false) {
	            continue(2);
	        }
	    }
	    $funcData[$key] = $val;
	}


	//标题匹配
	foreach($funcList as $key=>$val) {

		if (count($funcData) >= $limit) {
	        break;
	    }

		if(strpos($val['title'], $keyWord) !== false) {
			$funcData[$key] = $val;
		}
	}

	$i=0;

	if(!empty($funcData)) {

		foreach($funcData as $key=>$val) {
			$i++;
		    $title      = trim("{$key} - {$val['title']}");
		    $sub        = trim("{$val['prot']}");
		    
		    $objWorkFlow->result($i, "http://www.php.net/".$key, $title, $sub, 'func.png');
		}

	} else {
		$objWorkFlow->result(1, "http://www.php.net/".$keyWord, '糟糕…', '没找到, 去php.net搜搜看？', 'func.png', 'yes');
	}

	echo $objWorkFlow->toxml();




















