<?php
/*
 * qWikiOffice Desktop 1.0
 * Copyright(c) 2007-2010, Murdock Technologies, Inc.
 * licensing@qwikioffice.com
 *
 * http://www.qwikioffice.com/license
 */

class theme {

   private $os = null;

   /**
    * __construct()
    *
    * @access public
    * @param {class} $os The os.
    */
   public function __construct(os $os){
      if(!$os->session_exists()){
         die('Session does not exist!');
      }

      $this->os = $os;
   } // end __construct()

   /** get_all() Get all theme definition data.
    *
    * @access public
    * @return {array} An associative array with the theme id as the index.
    */
   public function get_all(){
      $sql = "SELECT
         id,
         data
         FROM
         qo_themes";

      return $this->query($sql);
   } // end get_all()

   /** get_active() Get active theme definitions.
    *
    * @access public
    * @return {array} An associative array with the theme id as the index.
    */
   public function get_active(){
      $sql = "SELECT
         id,
         data
         FROM
         qo_themes
         WHERE
         active = 1";

      return $this->query($sql);
   } // end get_active()

   /** get_by_id()
    *
    * @param {string} $id The theme id.
    * @return {stdClass} A data object
    */
   public function get_by_id($id){
      if(isset($id) && $id != ''){
         $sql = "SELECT
            id,
            data
            FROM
            qo_themes
            WHERE
            id = '".$id."'";

         $result = $this->query($sql);

         if($result){
            return $result[$id];
         }
      }

      return null;
   } // end get_by_id()

   /**
    * get_file() Returns the file for the theme.
    *
    * @access public
    * @param {string} $id The theme id.
    * @return {string}
    */
   public function get_file($id){
      // do we have the required params
      if(!isset($id) || $id == ''){
         return null;
      }

      $theme = $this->get_by_id($id);
      if(!$theme || !isset($theme->file) || $theme->file == ''){
         return null;
      }

      return $theme->file;
   } // end get_file()

   /**
    * query() Run a select query against the database.
    *
    * @access private
    * @param {string} $sql The select statement.
    * @return {array} An associative array with the definition id as the index.
    */
   private function query($sql){
      if(isset($sql) && $sql != ''){
         $result = $this->os->db->conn->query($sql);

         if($result){
            return $this->parse_result($result);
         }
      }

      return null;
   } // end query()

   /**
    * parse_result() Parses the query result.  Expects 'id' and 'data' fields.
    *
    * @access private
    * @param {PDOStatement} $result The result set as a PDOStatement object.
    * @return {array} An associative array with the definition id as the index.
    */
   private function parse_result($result){
      $response = array();

      if($result){
         $errors = array();

         while($row = $result->fetch(PDO::FETCH_ASSOC)){
            // decode the json data
            $decoded = json_decode($row['data']);

            if(!is_object($decoded)){
               $errors[] = "Script: theme.php, Method: parse_result, Message: 'qo_themes' table, 'id' ".$row['id']." has 'data' that could not be decoded";
               continue;
            }

            $response[$row['id']] = $decoded;
         }

         // errors to log?
         if(count($errors) > 0){
            $this->os->load('log');
            $this->os->log->error($errors);
         }
      }

      return count($response) > 0 ? $response : null;
   } // end parse_result()
}
?>