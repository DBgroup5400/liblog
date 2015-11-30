<?php
require_once "libdb.php";

class MenuLog extends db{
  /* protected propaties */
  protected $kind;
  protected $week;
  /* end of protected propaties */

  /* constructor */
  public function __construct( $__host, $__user, $__passwd ){
    $kind = array( 0 => "main",
                   1 => "dish",
                   2 => "sub" );
    $kind = array( 0 => "Mon",
                   1 => "Tue",
                   2 => "Wed",
                   3 => "Thu",
                   4 => "Fri",
                   5 => "Sat",
                   6 => "Sun", );
    parent::__construct( $__host, $__user, $__passwd );
  }
  /* end of constructor */

  /* public method */
  /* resist menu log to db */
  public function ResistMenuLog( $_uid ,$_log ){
    
  }
  /* end of public method */

  /* destructor */
  public function __destruct(){
    $this->_db_close();
  }
  /* end of destructor */
}
?>