<?php


$Env =   require_once '../env';

class Model {
    private $results;
    private $connection;
    private $last_id;

    function __construct($Env) {
        $this->connection = new mysqli($Env['DB_HOST'], $Env['DB_USERNAME'], $Env['DB_PASSWORD'] , $Env['DB_DATABASE'] ,$Env['DB_PORT'] );
        if ($this->connection->connect_errno) {
            throw new RuntimeException('Model Connection Faild: ' . $connection->connect_error);
            exit();
        }
    } # CONSTRACTOR

    public function Query($query, array $args = NULL) {
        $statement   =  $this->connection->prepare($query);
        $params = [];
        if ($args != null) {
            $types  = array_reduce($args, function ($string, $arg) use (&$params)  {
                $params[] = &$arg;
                if (is_float($arg)) {
                    $string .= 'd';
                } elseif (is_integer($arg)) {
                    $string .= 'i';
                } elseif (is_string($arg)) {
                    $string .= 's';
                } else {
                    $string .= 'b';
                }
                return $string;
            }, '');
            array_unshift($params, $types);
            call_user_func_array([$statement, 'bind_param'], $params);
        }

        if( $result = $statement->execute()) {
            $this->last_id = $statement->insert_id;

            $result = $statement->get_result();
            if($result == false) {
                $statement->close();
                return true;
            }
            else {
                $statement->close();
                return $result ;
            }
        }
        else {
             $statement->close();
             return false;
        }

    } # END OF QUERY

    public function close(){
        $this->$connection->close();
    } # close connection
    
    public function last_id(){
        return $this->last_id; 
    }
} # END OF MODEL

$DATABASE = new Model($Env);



?>
