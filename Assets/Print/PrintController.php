<?php
// require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__.' /vendor/autoload.php';
 

require_once __DIR__ . '/DB.php';

class PrintController{

	public $db = null;
	public $page = null;
	public $orientation = null;
	public $htmlfile = null;
	
	function __construct($method) {	
		echo __DIR__;exit;
		$this->db = new DB;
		return $this->$method();			
	}
	
	function print_test_file( $page='A4', $page_size = null, $path = null , $type= 'I', $file_name=null , $oreintation='L', $mode='utf-8', $margin_left=15, $margin_right=15, $margin_top=15, $margin_bottom=15, $margin_header=9, $margin_footer=90, $default_font='', $de_font_size=10){		
		
		if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['message']))
		{
			$default_config = [
                'mode' => $mode,
                'format' => !isset($page_size) ? $page : $page_size ,
                'default_font_size' => $de_font_size,
                'default_font' => $default_font,
                'margin_left' => $margin_left,
                'margin_right' => $margin_right,
                'margin_top' => $margin_top,
                'margin_bottom' => $margin_bottom,
                'margin_header' => $margin_header,
                'margin_footer' => $margin_footer,
                'orientation' => $oreintation ,
            ];			
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$message = $_POST['message'];

			$mpdf = new \Mpdf\Mpdf($default_config);
			$data = "";
			$data .= "<h1>Your Details</h1>";
			$data .='<strong>First Name</strong> '. $fname.'<br>';
			$data .='<strong>Last Name</strong> '. $lname.'<br>';
			$data .='<strong>Email</strong> '. $email .'<br>';
			$data .='<strong>Message</strong> '. $message.'<br>';
			$mpdf->WriteHtml($data);	
			if($path){	
				$mpdf->output( $path . "/" . (isset($file_name)?$file_name:rand(0,85555555)) ,'F');					
			}
			else
				$mpdf->output( (isset($file_name)?$file_name:rand(0,85555555)) , $type );
			
			header("Content-Type: application/json");
			echo json_encode(array('data'=>array('msg'=>'success')));	
		}
	}	
	
	
	function print_html_to_pdf( $page='A4', $page_size = null, $path = '', $type= 'I', $file_name=null, $htmlFileName='testHtml.php' , $oreintation='L', $mode='utf-8', $margin_left=15, $margin_right=15, $margin_top=15, $margin_bottom=15, $margin_header=9, $margin_footer=90, $default_font='', $de_font_size=10){		
				
		// pdf configuration
		$default_config = [
			'mode' => $mode,
			'format' => !isset($page_size) ? $page : $page_size ,
			'default_font_size' => $de_font_size,
			'default_font' => $default_font,
			'margin_left' => $margin_left,
			'margin_right' => $margin_right,
			'margin_top' => $margin_top,
			'margin_bottom' => $margin_bottom,
			'margin_header' => $margin_header,
			'margin_footer' => $margin_footer,
			'orientation' => $oreintation ,
		];
		$mpdf = new \Mpdf\Mpdf($default_config);
		
		// if  you want to send data to view put in session and do something on data inside the file
			
			$_SESSION['array'] = array(1,2,3,4,5) ;
			$_SESSION['url'] = '' ;
			
		// Finish sending data
		
		// this runs the files whom should be previewed, the ob_start and ob_end_clean hides the output here
		ob_start();
		$files = include (__DIR__ . '/'.$htmlFileName);	
		$files = ob_get_contents();	
		ob_end_clean();	
		
		//send the html generated data to pdf
		$mpdf->WriteHtml($files);
		
		
		//save the pdf file and then it is shown in iframe
		
		if($path){	
			$mpdf->output( $path . "/" . (isset($file_name)?$file_name:rand(0,85555555)) ,'F');					
		}
		else
			$mpdf->output( (isset($file_name)?$file_name:rand(0,85555555)) , $type );
		
		header("Content-Type: application/json");
		echo json_encode(array('data'=>array('msg'=>'success')));	
		
	}	
	
		
	
	function print_html_to_pdf_down( $page='A4', $page_size = null, $path = '', $type= 'D', $file_name=null, $htmlFileName='testHtml.php' , $oreintation='L', $mode='utf-8', $margin_left=15, $margin_right=15, $margin_top=15, $margin_bottom=15, $margin_header=9, $margin_footer=90, $default_font='', $de_font_size=10){		
				
		// pdf configuration
		$default_config = [
			'mode' => $mode,
			'format' => !isset($page_size) ? $page : $page_size ,
			'default_font_size' => $de_font_size,
			'default_font' => $default_font,
			'margin_left' => $margin_left,
			'margin_right' => $margin_right,
			'margin_top' => $margin_top,
			'margin_bottom' => $margin_bottom,
			'margin_header' => $margin_header,
			'margin_footer' => $margin_footer,
			'orientation' => $oreintation ,
		];
		$mpdf = new \Mpdf\Mpdf($default_config);
		
		// if  you want to send data to view put in session and do something on data inside the file
			
			$_SESSION['array'] = array(1,2,3) ;
			$_SESSION['url'] = '' ;
			
		// Finish sending data
		
		// this runs the files whom should be previewed, the ob_start and ob_end_clean hides the output here
		ob_start();
		$files = include (__DIR__ . '/'.$htmlFileName);	
		$files = ob_get_contents();	
		ob_end_clean();	
		
		//send the html generated data to pdf
		$mpdf->WriteHtml($files);
		
		
		$mpdf->output( (isset($file_name)?$file_name:rand(0,85555555)).".pdf" , $type );
		
		header("Content-Type: application/json");
		echo json_encode(array('data'=>array('msg'=>'success')));	
		
	}	
	
	
	function print_html_to_pdf_and_preview( $page='A4', $page_size = null, $path = '', $type= 'I', $file_name=null, $htmlFileName='testHtml.php' , $oreintation='L', $mode='utf-8', $margin_left=15, $margin_right=15, $margin_top=15, $margin_bottom=15, $margin_header=9, $margin_footer=90, $default_font='', $de_font_size=10){		
			
			// pdf configuration
			$default_config = [
                'mode' => $mode,
                'format' => !isset($page_size) ? $page : $page_size ,
                'default_font_size' => $de_font_size,
                'default_font' => $default_font,
                'margin_left' => $margin_left,
                'margin_right' => $margin_right,
                'margin_top' => $margin_top,
                'margin_bottom' => $margin_bottom,
                'margin_header' => $margin_header,
                'margin_footer' => $margin_footer,
                'orientation' => $oreintation ,
            ];
			$mpdf = new \Mpdf\Mpdf($default_config);
			
			// if  you want to send data to view put in session and do something on data inside the file
				
				$_SESSION['array'] = array(1,2,3) ;
				$_SESSION['url'] = '' ;
				
			// Finish sending data
			
			// this runs the files whom should be previewed, the ob_start and ob_end_clean hides the output here
			ob_start();
			$files = include (__DIR__ . '/'.$htmlFileName);	
			$files = ob_get_contents();	
			ob_end_clean();	
			
			//send the html generated data to pdf
			$mpdf->WriteHtml($files);
			
			
			//save the pdf file and then it is shown in iframe
			if( $path == '' ){
				$path = 'PrintFiles';
			}			
			$file_path = $path . "/" . (isset($file_name)?$file_name:rand(0,85555555));			
			$mpdf->output( $file_path.".pdf" ,'F');					
			
			//save the pdf file path in session and then it is shown in iframe
			$_SESSION['file_path'] = $file_path.'.pdf';			
			//loads the preview
			
			$_SESSION['back_url'] = 'index.php';
			header("location:printPreview.php");		
	}	
	
	
	function back_page(){		
		$back_url = $_POST['back_page_value'];	
		if($back_url == 'index.php'){
			return $this->index();		
		}
		elseif($back_url == 'clients.php')
		{
			return $this->index();	
		}
	}	
	
	
	function index()
	{
		// php script staff		
		return header("location:index.php");
	}
	
	
	
		
	
	function print_html_to_pdf_downjs( $page='A4', $page_size = null, $path = '.', $type= 'D', $file_name=null, $htmlFileName='testHtml.php' , $oreintation='L', $mode='utf-8', $margin_left=15, $margin_right=15, $margin_top=15, $margin_bottom=15, $margin_header=9, $margin_footer=90, $default_font='', $de_font_size=10){		
		
		// pdf configuration
		$default_config = [
			'mode' => $mode,
			'format' => !isset($page_size) ? $page : $page_size ,
			'default_font_size' => $de_font_size,
			'default_font' => $default_font,
			'margin_left' => $margin_left,
			'margin_right' => $margin_right,
			'margin_top' => $margin_top,
			'margin_bottom' => $margin_bottom,
			'margin_header' => $margin_header,
			'margin_footer' => $margin_footer,
			'orientation' => $oreintation ,
		];
		$mpdf = new \Mpdf\Mpdf($default_config);
		
		// if  you want to send data to view put in session and do something on data inside the file
			
			$_SESSION['array'] = array(1,2,3) ;
			$_SESSION['url'] = '' ;
			
		// Finish sending data
		
		// this runs the files whom should be previewed, the ob_start and ob_end_clean hides the output here
		ob_start();
		$files = include (__DIR__ . '/'.$htmlFileName);	
		$files = ob_get_contents();	
		ob_end_clean();	
		
				
		//send the html generated data to pdf
		$mpdf->WriteHtml($files);		
		$mpdf->output( $path . "/PrintFiles/" . 'down.pdf' ,'F');	
	
		
		$file = __DIR__ ."\\PrintFiles\\". 'down.pdf'; //file which in fact exists
		
		header("Content-Type: application/json");
		echo json_encode(array('data'=>array('msg'=>'success','file'=>$file,'name'=>'down.pdf')));	
		
	}	
		
		
		
		
		
	
	function print_test_file_form(){		
				
			$page = $_POST['page'];	
			$oreintation = $_POST['oreintation'];	
			$file_name = $_POST['filename'];	
			$path = $_POST['path'];	
			$type = $_POST['type'];
			
			$default_config = [
                'format' => !isset($page_size) ? $page : $page_size ,
                'orientation' => $oreintation ,
            ];			
		
			$mpdf = new \Mpdf\Mpdf($default_config);
			$data = "";
			$data .= "<h1>Your Details</h1>";
		
			$mpdf->WriteHtml($data);	
			if($path){	
				$mpdf->output( $path  . (isset($file_name)?$file_name:rand(0,85555555)) ,'F');					
			}
			else
				$mpdf->output( (isset($file_name)?$file_name:rand(0,85555555)) , $type );
			
			
			echo $data;exit;
		
	}	
		
		
	
	
}
	
	
?>
  