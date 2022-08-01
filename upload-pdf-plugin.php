<?php
/*
Plugin Name: Access Statements Pdf
Description: Upload pdf file for Access Statements
Author: 
Version: 1
Author URI: 
*/

// Deny direct access
defined('ABSPATH') or die("No script kiddies please!");
class export_data_to_csv1{

    private $data;
    private $headers;

    function __construct($headersArr, $dataArr, $filename){
        $this->data = $dataArr;  
		    $this->headers = $headersArr;   

        $generatedDate = date('d-m-Y His');                          
        $csvFile = $this->generate_csv();                          
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);                   
        header("Content-Type: application/octet-stream");
        //header("Content-Disposition: attachment; filename=\"" . $filename . "_" . $generatedDate . ".csv\";" );
        header("Content-Transfer-Encoding: binary");

        echo $csvFile;
        exit;

    }

}

function access_statements_menu() {
	add_object_page( 'Access Statements Pdf', 'Access Statements', 'manage_options', 'access-statements', 'access_statements_list');
}
add_action('admin_menu', 'access_statements_menu'); 

function access_statements_list()
{
	
?>

        <div class="wrap">
            <h1>Access Statements</h1>
           <hr>


           <?php
            if(isset($_POST['upload']))
            {

               if( ! empty( $_FILES ) ) 
               {
                  $file=$_FILES['file'];   // file array
                  $upload_dir=wp_upload_dir();
                  $path=$upload_dir['basedir'].'/statements/';  //upload dir.
                  if(!is_dir($path)) { mkdir($path); }
                  $attachment_id = upload_user_file( $file ,$path);

               }
                }
             ?>
        <form action="" method="post" enctype="multipart/form-data" class="form-inline">
            <div class="form-group">
            <label class="sr-only" for="pdffile"><span style="font-size: 16px;font-weight: 600;">Upload Pdf Files : </span></label>
            <input type="file" name="file">
             <input name="upload" value="Upload File" style="background: #ff8601;color: #fff;font-weight: 600;font-size: 16px;box-shadow: none;padding: 3px 10px;" type="submit">
          </div>
        </form> 

<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => __( '&laquo;', 'text-domain' ),
			'next_text' => __( '&raquo;', 'text-domain' ),
			'total' => $num_of_pages,
			'current' => $pagenum
		) );
		
		if ( $page_links ) {
			echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
		}
		
		echo "</div>";

}

function access_statements_view(){
	
}

function access_statements_activate(){
	
}

function access_statements_deactivate(){
	
}

register_activation_hook( __FILE__, 'access_statements_activate' );
register_deactivation_hook( __FILE__, 'access_statements_deactivate' );
?>
