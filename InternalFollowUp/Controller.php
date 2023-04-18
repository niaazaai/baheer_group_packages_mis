<?php 

require_once 'Model.php';

class Controller
{
    
    private $Database;

    public function __construct($Database)  {
        $this->Database = $Database;
    } # CONSTRACTOR

    public function QueryData( $query, array $args = NULL ){
        $result = $this->Database->QUERY($query,$args);
        return $result;
    }

    public function CleanInput($input){
        $html = htmlspecialchars($input); 
        $html = trim($html);
        return $html; 
    }

    
    #Search Assets According To Fields
    public function Search($TableName , $FieldName , $Term , $Columns){
        $Field = $this->CleanInput($FieldName);
        $SearchTerm  = $this->CleanInput($Term);
        $Columns  = $this->CleanInput($Columns);
        $result = $this->QueryData("SELECT $Columns FROM $TableName WHERE $Field  LIKE LOWER('%$SearchTerm%')", []);
        if ($result->num_rows > 0) {
            return $result;
        } 
        else  return false; 
         
    } # END OF Search METHOD 

    public function close(){
        $this->Database->close();
    }
 
}

  
$Controller = new Controller($DATABASE); 


?>

