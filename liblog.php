<?php
require_once "libdb.php";

class MenuLog extends db{
  /* protected propaties */
  protected $kind;
  protected $week;
  /* end of protected propaties */

  /* constructor */
  public function __construct( $__host, $__user, $__passwd, $__uid ){
    $this->kind = array( 0 => "main",
                   1 => "dish",
                   2 => "sub" );
    $this->week = array( 0 => "Mon",
                   1 => "Tue",
                   2 => "Wed",
                   3 => "Thu",
                   4 => "Fri",
                   5 => "Sat",
                   6 => "Sun", );
    parent::__construct( $__host, $__user, $__passwd );
    $query = "CREATE TABLE UM".$__uid." ( Menu_Name text, Kind_Name varchar(10), Date DATE );";
    $result = $this->_db_throw_query( "Users_Geo", $query );
  }
  /* end of constructor */

  /* public method */
  /* method that resist menu log to db */
  public function ResistMenuLog( $_uid, $_log ){
    $query = "TRUNCATE TABLE UM".$_uid.";";
    $result = $this->_db_throw_query( "Users_Geo", $query );

    $query = "";
    $tmp = "INSERT INTO UM".$_uid." VALUES ( '";
    for( $i = 0; $i < 7; $i++ ){
      for( $j = 0; $j < 3; $j++ ){
        if( $j == 2 ){
            if( strpos( $_log[$this->week[$i]][$this->kind[$j]], '|' ) !== false ){
              $div = explode( '|', $_log[$this->week[$i]][$this->kind[$j]] );
              $size = count( $div );
              for( $k = 0; $k < $size; $k++ ){
                $query = $query.$tmp.$div[$k]."', '".$this->kind[$j]."', ( NOW() + INTERVAL ".$i." DAY ) );";
              }
              break;
            }
        }
        $query = $query.$tmp.$_log[$this->week[$i]][$this->kind[$j]]."', '".$this->kind[$j]."', ( NOW() + INTERVAL ".$i." DAY ) );";
      }
    }
    $this->_db_select( "Users_Geo" );
    $result = mysqli_multi_query($this->_connection, $query);
    if( !$result ){
      print( "Quely Failed.\n".mysqli_error( $this->_connection ) );
      return false;
    }
    do{
      mysqli_store_result( $this->_connection );
    } while( mysqli_next_result( $this->_connection ) );

    return true;
  }
  /* method that get menu log */
  public function GetMenuLog( $_uid ){
    $days = 0;
    $back_date = NULL;
    $back_kind = NULL;
    $return = array();
    $query = "SELECT * from UM".$_uid.";";

    $result = $this->_db_throw_query( "Users_Geo", $query );
    if( !$result ){
      print( "Quely Failed.\n".mysqli_error( $this->_connection ) );
      return NULL;
    }

    while( ( $record = mysqli_fetch_assoc( $result ) ) != NULL ){
      if( $back_date != NULL && strcmp( $record["Date"], $back_date ) != 0 )
        $days++;
      if( $record["Kind_Name"] == $back_kind )
        $return[$this->week[$days]][$back_kind] = $return[$this->week[$days]][$back_kind]."|".$record["Menu_Name"];
      else
        $return[$this->week[$days]][$record["Kind_Name"]] = $record["Menu_Name"];
      $back_date = $record["Date"];
      $back_kind = $record["Kind_Name"];
    }
    return $return;
  }
  /* end of public method */

  /* destructor */
  public function __destruct(){
    $this->_db_close();
  }
  /* end of destructor */
}
?>