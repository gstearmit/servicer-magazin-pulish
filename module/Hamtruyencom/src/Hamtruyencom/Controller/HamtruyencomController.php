<?php

namespace Hamtruyencom\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Hamtruyencom\Model\Hamtruyencom;
use Hamtruyencom\Form\HamtruyencomForm;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;

// rss
use Zend\Feed\Reader as feed;
use Zend\View\Model\JsonModel;
use Zend\Http\Client as HttpClient;
// DOM
 use DOMDocument;
 use DOMXPath;
 use DOMNode;
 use Zend\Stdlib\ErrorHandler;
use Zend\Dom\Query;

class HamtruyencomController extends AbstractActionController {
	protected $hamtruyencomTable;
	public function indexAction() {
		
		// if (!$this->zfcUserAuthentication()->hasIdentity()) {
		// return $this->redirect()->toRoute('zfcuser/login');
		// }
		$select = new Select ();
		$order_by = $this->params ()->fromRoute ( 'order_by' ) ? $this->params ()->fromRoute ( 'order_by' ) : 'id';
		$order = $this->params ()->fromRoute ( 'order' ) ? $this->params ()->fromRoute ( 'order' ) : Select::ORDER_ASCENDING;
		$page = $this->params ()->fromRoute ( 'page' ) ? ( int ) $this->params ()->fromRoute ( 'page' ) : 1;
		
		$hamtruyencoms = $this->getHamtruyencomTable ()->fetchAll ( $select->order ( $order_by . ' ' . $order ) );
		$itemsPerPage = 3;
		
		$hamtruyencoms->current ();
		$paginator = new Paginator ( new paginatorIterator ( $hamtruyencoms ) );
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $itemsPerPage )->setPageRange ( 4 );
		
		return new ViewModel ( array (
				// 'hamtruyencoms' => $this->gethamtruyencomTable()->fetchAll(),
				'order_by' => $order_by,
				'order' => $order,
				'page' => $page,
				'paginator' => $paginator 
		) );
	}
	public function addAction() {
		$form = new HamtruyencomForm ();
		$form->get ( 'submit' )->setAttribute ( 'value', 'Add' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$hamtruyencom = new Hamtruyencom ();
			$form->setInputFilter ( $hamtruyencom->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$hamtruyencom->exchangeArray ( $form->getData () );
				$this->getHamtruyencomTable ()->saveHamtruyencom ( $hamtruyencom );
				
				// Redirect to list of hamtruyencoms
				return $this->redirect ()->toRoute ( 'hamtruyencom' );
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'hamtruyencom', array (
					'action' => 'add' 
			) );
		}
		$hamtruyencom = $this->getHamtruyencomTable ()->getHamtruyencom ( $id );
		
		$form = new HamtruyencomForm ();
		$form->bind ( $hamtruyencom );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$this->getHamtruyencomTable ()->saveHamtruyencom ( $hamtruyencom );
				
				// Redirect to list of hamtruyencoms
				return $this->redirect ()->toRoute ( 'hamtruyencom' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
		$id = ( int ) $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'hamtruyencom' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ()->get ( 'del', 'No' );
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ()->get ( 'id' );
				$this->getHamtruyencomTable ()->deleteHamtruyencom ( $id );
			}
			
			// Redirect to list of hamtruyencoms
			return $this->redirect ()->toRoute ( 'hamtruyencom' );
		}
		
		return array (
				'id' => $id,
				'hamtruyencom' => $this->getHamtruyencomTable ()->getHamtruyencom ( $id ) 
		);
	}
	
	
	//http://www.wattpad.com/rss?mode=2&language=19
	public function wattpadAction() {
		try {
			// lay theo catalogue truyen : http://www.wattpad.com/rss?mode=1&language=19&category=5 
			// lay theo rss languege viet nam	
			$wattpad = feed\Reader::import ( 'http://www.wattpad.com/rss?mode=2&language=19' );
		} catch ( feed\Exception\RuntimeException $e ) {
			echo "error : " . $e->getMessage ();
			exit ();
		}
	
		$wattpad_array  = array (
				'title' => $wattpad->getTitle(),
				'description' => $wattpad->getDescription(),
				'link' => $wattpad->getLink(),
				'items' => array ()
		);
	
	
		foreach ( $wattpad as $item )
		{

			//Zend/Feed/Reader/Entry/rss.php
			$wattpad_array ['items'] [] = array (
					'title' => $item->getTitle (),
					'link' => $item->getLink (),
					'image' => '/default.png',
					'description' => $item->getDescription(),
			);
		}
		
	
	
		return new ViewModel ( array (
				'data' => $wattpad_array
		) );
	}
	
	
	
	
	public function runtimerssAction()
	{
		
		// PRINT "Elapsed time was $time seconds.";
		//echo '<script>window.open("http://127.0.0.1:1913/wattpad/haivltv", "_blank", "width=400,height=500")</script>';
		$time = time();
		$starttime = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time) ,date("Y", $time)));
		$endtime = date("Y-m-d", mktime(0,0,0,date("n", $time),date("j",$time)+ 1 ,date("Y", $time)));
		var_dump($starttime);
		var_dump($endtime);
		
		// $totaltime = ($endtime - $starttime);
		// echo "This page was created in ".$totaltime." seconds";
		
		$startime = "2014-06-18 12:05";
		$starttime = strtotime($starttime);
		$oneday = 60*60*0.1;
		if( $starttime < (time()-$oneday) ) {
			echo 'more than one day since start';
			echo '<script>window.open("http://127.0.0.1:1913/wattpad/haivltv", "_blank", "width=400,height=500")</script>';
		} else {
			echo 'started within the last day';
		}
		
		
	}
	
	public function hamtruyencomAction()
	{
		$domain = "http://hamtruyen.com";
		$url_haivltv = "http://hamtruyen.com/cuu-dinh-ky-1385.html";
		$client = new HttpClient();
		$client->setAdapter('Zend\Http\Client\Adapter\Curl');
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8'); //set content-type
		$client->setUri($url_haivltv);
		$result                 = $client->send();
		$body                   = $result->getBody();  //content of the web
		//echo $body;die;
		$dom = new Query($body);
		$title = $dom->execute('.wrapper_sanpham .ten_truyen');
		foreach($title as $key=>$r)
		{
			$aelement     = $r->getElementsByTagName("a")->item(0);	
			if ($aelement->hasAttributes())
			{
				$nameapp = 'hamtruyencom';
				$title =  $aelement->textContent;
				$link  = $url_haivltv; 
			}
		}
		
		//.wrapper_sanpham .content_noidung_tomtat
		$content_detail_lop = $dom->execute('.wrapper_sanpham .content_noidung_tomtat');
		foreach ($content_detail_lop as $keyhai => $valuehaivl)
		{
			$description = $this->innerHTML($valuehaivl);
			
		}
 		// get Thumbnail img
		$img = $dom->execute('.wrapper_sanpham .image_anh img');
		foreach ($img as $keydo => $mainelemen)
		{	
			if ($mainelemen->hasAttributes())
			{
				$image_thumbnail = $mainelemen->getAttributeNode('src')->nodeValue;
			}
				
		}
	
		// get Chap of story .wrapper_sanpham .last_chap_update
		$get_chap = $dom->execute('.wrapper_sanpham .last_chap_update');
		//var_dump($get_chap->count());die;
		foreach ($get_chap as $keyhai => $valuehaivl)
		{
			$conten_text     = $valuehaivl->getElementsByTagName("a")->item(0);
			if ($aelement->hasAttributes())
			{
				$text =  $conten_text->textContent;
				$pieces = explode(" ", $text);       // get number chapter
				foreach ($pieces as $element) 
				{
					if (is_numeric($element)) 
					{
				        $numberChap = $element;
						//var_dump($aelemen23t);	
 		     		}
				}
				
			}
		}

		$hamtruyencom = array (
				'nameapp' =>$nameapp,
				'title' => $title,
				'link' =>$link,
				'description'=>$description,
				'numberchap'=>$text,
				'image_thumbnail' =>$image_thumbnail,
				'category'=>'',
				'items' => array (),
		);
		
		
		// .doctruyen_last_first :  link doc truyen
		$link_story_get = $dom->execute('.wrapper_sanpham .doctruyen_last_first');
		//var_dump($link_story_get->count());die;
		foreach ($link_story_get as $key => $aelement)
		{
			$conten_text     = $aelement->getElementsByTagName("a")->item(0);
			if ($aelement->hasAttributes())
			{
				$link_story_start  = $domain.$conten_text->getAttributeNode('href')->nodeValue;
				
				// eplox get string loop
				$array_explo = explode("/", $conten_text->getAttributeNode('href')->nodeValue);  // $conten_text->getAttributeNode('href')->nodeValue) = '/doc-truyen/cuu-dinh-ky-chapter-1.html'
				$link_story = $array_explo[1];  // doc-truyen
				$url_start = explode(".",$array_explo[2]);                                      // cuu-dinh-ky-chapter-1.html
				$url_next = $url_start[0]; 
				$pieces2 = explode('-', $url_next);
				foreach ($pieces2 as $e)
				{
					if (is_numeric($e))
					{
						$url_number = $e;
					}
				}
				
				//$url_loop = preg_replace('/1/', '', 'cuu-dinh-ky-chapter-1') ;
				//$url_loop = str_replace('1', '', 'cuu-dinh-ky-chapter-1') ;
				
				$reple = '/'.$url_number.'/';                        //"'/.1.'/";
				$url_loop = preg_replace($reple, '', $url_next) ;   // 'cuu-dinh-ky-chapter-'
				$link_loop_real = $domain.'/'.$link_story.'/'.$url_loop;
				
			}
		}
		
		$client2 = new HttpClient();
		$client2->setAdapter('Zend\Http\Client\Adapter\Curl');
		
		$response2 = $this->getResponse();
		$response2->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8'); //set content-type
		
		$client2->setUri('http://hamtruyen.com/doc-truyen/cuu-dinh-ky-chapter-1.html');
		$result2                 = $client2->send();
		$body2                   = $result2->getBody();  //content of the web
		
		echo $body2; die('loi o day ');
			
		//echo $body2;
		$dom2 = new Query($body2);
		//get video
		$img_array = $dom2->execute('#content .content_chap img');
		
		var_dump($img_array->count());
		//var_dump($img_array->getXpathQuery());
		die;
		
		
		
		
		
		
		
		

	// GetConTentFull Deatil
			 //	$i=0;
				for($j=1;$j<$numberChap ;$j++)
				{
					$chap_look = "Chapter ".$j;
					$get_img_link = $link_loop_real.$j.'.html';
// 					var_dump($get_img_link);
// 					die;
					$content_detail_full = array();
					
					$content_detail_full = $this->getContent_chap_img($get_img_link);
					$hamtruyencom['items'][] = array(
							'Chap'=>$chap_look,
							'detail'=>$content_detail_full,
					);
				//	$i++;
				    break;
				}
		
		var_dump($array_explo);
		echo '</br>';
		var_dump($url_array);
		echo 'loop</br>';
		echo '<pre>';
		print_r($pieces2);
		echo '</pre>';
		echo '</pr>';
		var_dump($url_loop);
		
		//die;
// 		$hamtruyencom['items'][] = array(
// 			'link_story'=>$link_story_start,
// 		);
		
	
		
		
			// 		// save
			// 		foreach ($haivltv as $keysave =>$valuehaivlSave)
				// 		{
				// 			$arry_tmp = array();
				// 			$arry_tmp = (array)$valuehaivlSave;
				// 			$rssget = New Rssget();
				// 			$rssget->exchangeArray($arry_tmp);
				// 			$this->getRssgetTable()->saveRssget($rssget);
				// 		}
				
			
			
	          	echo 'hamtruyencom';
							echo '<pre>';
							print_r($hamtruyencom);
							echo '</pre>';
						    var_dump($numberChap);
						
							die;
	
	
		return new JsonModel(array(
				'data' =>$hamtruyencom,
		));
	}

	public function getContent_chap_img($url = null)
	{
		// get Content
		if($url === null)
		{
			return $array_img = null;
		}
		else {
			$client2 = new HttpClient();
			$client2->setAdapter('Zend\Http\Client\Adapter\Curl');
	
			$response2 = $this->getResponse();
			$response2->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8'); //set content-type
	
			$client2->setUri($url);
			$result2                 = $client2->send();
			$body2                   = $result2->getBody();  //content of the web
	
			//return $body2; die;
			
			//echo $body2;
			$dom2 = new Query($body2);
			//get video
			$img_array = $dom2->execute('.content_chap img');
			//$arra = (array)$video;// //*[contains(concat(' ', normalize-space(@class), ' '), ' content_chap ')]//img
			$a = $img_array->count();
	        return $a;exit();
	        
			foreach ($img_array as $keyvd => $valuevd)
			{
				$array_img = $this->innerHTML($valuevd);	
			}
	
			return $array_img;
		}
	}
	
	public function truyentranhtuancomAction()
	{
		$domain = "http://truyentranhtuan.com";
		$url_haivltv = "http://truyentranhtuan.com/cuu-dinh-ky/";
		$client = new HttpClient();
		$client->setAdapter('Zend\Http\Client\Adapter\Curl');
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8'); //set content-type
		$client->setUri($url_haivltv);
		$result                 = $client->send();
		$body                   = $result->getBody();  //content of the web
		//echo $body;die;
		$dom = new Query($body);
// 		$title = $dom->execute('.wrapper_sanpham .ten_truyen');
// 		foreach($title as $key=>$r)
// 		{
// 			$aelement     = $r->getElementsByTagName("a")->item(0);
// 			if ($aelement->hasAttributes())
// 			{
// 				$nameapp = 'hamtruyencom';
// 				$title =  $aelement->textContent;
// 				$link  = $url_haivltv;
// 			}
// 		}
	
// 		//.wrapper_sanpham .content_noidung_tomtat
// 		$content_detail_lop = $dom->execute('.wrapper_sanpham .content_noidung_tomtat');
// 		foreach ($content_detail_lop as $keyhai => $valuehaivl)
// 		{
// 			$description = $this->innerHTML($valuehaivl);
				
// 		}
		// get Thumbnail img
		$img = $dom->execute('#main-content #infor-box .manga-cover img');
		//var_dump($img->count()); die;
		foreach ($img as $keydo => $mainelemen)
		{
			if ($mainelemen->hasAttributes())
			{
				$image_thumbnail = $mainelemen->getAttributeNode('src')->nodeValue;
			}
	
		}
		
	   var_dump($image_thumbnail);
	
		// get Chap of story .wrapper_sanpham .last_chap_update
		$get_chap = $dom->execute('#main-content #manga-chapter .chapter-name');
		//var_dump($get_chap->count());die;
		
		$number_loop_ = $get_chap->count();
		$i=0;
		$array = array();
	    foreach($get_chap as $key=>$r)
			{
				
 				$aelement     = $r->getElementsByTagName("a")->item(0);
				if ($aelement->hasAttributes()) 
				{
					$nameChapter[$i]->namechap = $aelement->textContent;
					$link_chap[$i]->link_chap = $aelement->getAttributeNode('href')->nodeValue;
					
					//$tmp = array();
					$tmp[$i]->namechap = $aelement->textContent;
					$tmp[$i]->link_chap = $aelement->getAttributeNode('href')->nodeValue;
					//$array[] = $tmp;
					$array = $tmp;
				}
				$i++;
		
			}
	
// 			// swap
// 			$array = array();
// 			foreach ($results as $result)
// 			{
// 				$tmp = array();
// 				$tmp= $result;
// 				$array[] = $tmp;
// 			}
			
			
		$hamtruyencom = array (
// 				'nameapp' =>$nameapp,
// 				'title' => $title,
// 				'link' =>$link,
// 				'description'=>$description,
// 				'numberchap'=>$number_loop_,
// 				'image_thumbnail' =>$image_thumbnail,
// 				'category'=>'',
				//'items' => array (),
				'namechatpter'=>array (),
				'link_chapter' => array (),
		);
		
		
		$hamtruyencom['namechatpter'][] = $nameChapter;
		$hamtruyencom['link_chapter'][] = $link_chap;
		
		
		echo 'namechatpter';
		echo '<pre>';
		print_r($array);
		echo '</pre>';
		die;
	
// 		// .doctruyen_last_first :  link doc truyen
// 		$link_story_get = $dom->execute('.wrapper_sanpham .doctruyen_last_first');
// 		//var_dump($link_story_get->count());die;
// 		foreach ($link_story_get as $key => $aelement)
// 		{
// 			$conten_text     = $aelement->getElementsByTagName("a")->item(0);
// 			if ($aelement->hasAttributes())
// 			{
// 				$link_story_start  = $domain.$conten_text->getAttributeNode('href')->nodeValue;
	
// 				// eplox get string loop
// 				$array_explo = explode("/", $conten_text->getAttributeNode('href')->nodeValue);  // $conten_text->getAttributeNode('href')->nodeValue) = '/doc-truyen/cuu-dinh-ky-chapter-1.html'
// 				$link_story = $array_explo[1];  // doc-truyen
// 				$url_start = explode(".",$array_explo[2]);                                      // cuu-dinh-ky-chapter-1.html
// 				$url_next = $url_start[0];
// 				$pieces2 = explode('-', $url_next);
// 				foreach ($pieces2 as $e)
// 				{
// 					if (is_numeric($e))
// 					{
// 						$url_number = $e;
// 					}
// 				}
	
// 				//$url_loop = preg_replace('/1/', '', 'cuu-dinh-ky-chapter-1') ;
// 				//$url_loop = str_replace('1', '', 'cuu-dinh-ky-chapter-1') ;
	
// 				$reple = '/'.$url_number.'/';                        //"'/.1.'/";
// 				$url_loop = preg_replace($reple, '', $url_next) ;   // 'cuu-dinh-ky-chapter-'
// 				$link_loop_real = $domain.'/'.$link_story.'/'.$url_loop;
	
// 			}
// 		}
	
// 		$client2 = new HttpClient();
// 		$client2->setAdapter('Zend\Http\Client\Adapter\Curl');
	
// 		$response2 = $this->getResponse();
// 		$response2->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8'); //set content-type
	
// 		$client2->setUri('http://hamtruyen.com/doc-truyen/cuu-dinh-ky-chapter-1.html');
// 		$result2                 = $client2->send();
// 		$body2                   = $result2->getBody();  //content of the web
	
// 		echo $body2; die('loi o day ');
			
// 		//echo $body2;
// 		$dom2 = new Query($body2);
// 		//get video
// 		$img_array = $dom2->execute('#content .content_chap img');
	
// 		var_dump($img_array->count());
// 		//var_dump($img_array->getXpathQuery());
// 		die;
	
	
	
	
	
	
	
	
	
// 		// GetConTentFull Deatil
// 		//	$i=0;
// 		for($j=1;$j<$numberChap ;$j++)
// 		{
// 		$chap_look = "Chapter ".$j;
// 				$get_img_link = $link_loop_real.$j.'.html';
// 				// 					var_dump($get_img_link);
// 		// 					die;
// 		$content_detail_full = array();
			
// 		$content_detail_full = $this->getContent_chap_img($get_img_link);
// 		$hamtruyencom['items'][] = array(
// 				'Chap'=>$chap_look,
// 				'detail'=>$content_detail_full,
// 		);
// 		//	$i++;
// 		break;
// 		}
	
// 		var_dump($array_explo);
// 		echo '</br>';
// 		var_dump($url_array);
// 		echo 'loop</br>';
// 		echo '<pre>';
// 		print_r($pieces2);
// 		echo '</pre>';
// 			echo '</pr>';
// 			var_dump($url_loop);
	
// 		//die;
// 			// 		$hamtruyencom['items'][] = array(
// 			// 			'link_story'=>$link_story_start,
// 			// 		);
	
	
	
	
// 			// 		// save
// 			// 		foreach ($haivltv as $keysave =>$valuehaivlSave)
// 			// 		{
// 			// 			$arry_tmp = array();
// 			// 			$arry_tmp = (array)$valuehaivlSave;
// 			// 			$rssget = New Rssget();
// 			// 			$rssget->exchangeArray($arry_tmp);
// 			// 			$this->getRssgetTable()->saveRssget($rssget);
// 			// 		}
	
				
				
			echo 'hamtruyencom';
			echo '<pre>';
			print_r($hamtruyencom);
			echo '</pre>';
			var_dump($numberChap);
	
			die;
	
	
		return new JsonModel(array(
			'data' =>$hamtruyencom,
		));
	}
	
	
	
	
	public function innerHTML( $contentdiv ) {
		$r = '';
		$elements = $contentdiv->childNodes;
		foreach( $elements as $element ) {
			if ( $element->nodeType == XML_TEXT_NODE ) {
				$text = $element->nodeValue;
				// IIRC the next line was for working around a
				// WordPress bug
				//$text = str_replace( '<', '&lt;', $text );
				$r .= $text;
			}
			// FIXME we should return comments as well
			elseif ( $element->nodeType == XML_COMMENT_NODE ) {
				$r .= '';
			}
			else {
				$r .= '<';
				$r .= $element->nodeName;
				if ( $element->hasAttributes() ) {
					$attributes = $element->attributes;
					foreach ( $attributes as $attribute )
						$r .= " {$attribute->nodeName}='{$attribute->nodeValue}'" ;
				}
				$r .= '>';
				$r .= $this->innerHTML( $element );
				$r .= "</{$element->nodeName}>";
			}
		}
		return $r;
	}
	


	
	public function get_data($url) {
		// return data: not html
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_POST, TRUE);             // Use POST method
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3");  // Define POST data values
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	

	/**
	 * Fetch the page source and cache it, ensuring it's saved as UTF-8
	 *
	 * @param  string $url
	 * @return string
	 */
	public function fetch($url)
	{
		$content = '';
		$md5 = md5($url);
		$path = __DIR__.'/cache/' . $md5;
		if (!file_exists($path)) {
			$content = file_get_contents($url);
			$content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
			file_put_contents($path, $content);
		} else {
			$content = file_get_contents($path);
		}
		return $content;
	}
	
	
	
	public function getHamtruyencomTable() {
		if (! $this->hamtruyencomTable) {
			$sm = $this->getServiceLocator ();
			$this->hamtruyencomTable = $sm->get ( 'Hamtruyencom\Model\HamtruyencomTable' );
		}
		return $this->hamtruyencomTable;
	}
}
