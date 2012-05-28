<?php
/*
 * qWikiOffice Desktop 1.0
 * Copyright(c) 2007-2010, Murdock Technologies, Inc.
 * licensing@qwikioffice.com
 *
 * http://www.qwikioffice.com/license
 */

class member {

	private $os;
	private $errors;

   /** __construct()
    *
    * @access public
    * @param {class} $os The os.
    */
	public function __construct($os){
		$this->os = $os;
		$this->errors = array();
	} // end __construct()

   /**
    * get_data()
    * Returns an associative array containing name/value pairs.
    *
    * @param {Integer} $member_id
    */
   public function get_data($member_id){
      if(isset($member_id) && $member_id != ''){
         $sql = "SELECT * FROM qo_members WHERE id = ".$member_id;

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return $row;
            }
         }
      }

      return null;
   } // end get_data()

   /**
    * get_field_value()
    * Returns the members record value for the passed in field.
    *
    * @param {Integer} $member_id
    * @param {String} $field
    */
   public function get_field_value($member_id, $field){
      if(isset($member_id, $field) && $member_id != '' && $field != ''){
         $sql = "SELECT ".$field." FROM qo_members WHERE id = ".$member_id;

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return $row[$field];
            }
         }
      }

      return null;
   } // end get_field_value()

   /**
    * exits() Returns the member id if a record exists for the passed in email address.
    *
    * @access public
    * @param {string} $email The members email address
    * @return {string} The id on success.  False on failure.
    */
   public function exists($email){
      if(isset($email) && $email != ''){
         $sql = "SELECT
            id
            FROM
            qo_members
            WHERE
            email_address = '".$email."'  AND active = 1";;

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return $row['id'];
            }
         }
      }

      return false;
   } // end exits()

    /**
     * exits_cedula() Returns the member id if a record exists for the passed in cedula.
     *
     * @access public
     * @param {string} $cedula The members cedula
     * @return {string} The id on success.  False on failure.
     */
    public function exists_cedula($cedula){
        if(isset($cedula) && $cedula != ''){
            $sql = "SELECT
            id
            FROM
            qo_members
            WHERE
            cedula = '".$cedula."'  AND active = 1";

            $result = $this->os->db->conn->query($sql);
            if($result){
                $row = $result->fetch(PDO::FETCH_ASSOC);
                if($row){
                    return $row['id'];
                }
            }
        }

        return false;
    } // end exits_cedula()

    /**
     * exits_cedula_todos() Returns the member id if a record exists for the passed in cedula.
     *
     * @access public
     * @param {string} $cedula The members cedula
     * @return {string} The id on success.  False on failure.
     */
    public function exists_cedula_todos($cedula){
        if(isset($cedula) && $cedula != ''){
            $sql = "SELECT
            id
            FROM
            qo_members
            WHERE
            cedula = '".$cedula."'";

            $result = $this->os->db->conn->query($sql);
            if($result){
                $row = $result->fetch(PDO::FETCH_ASSOC);
                if($row){
                    return $row['id'];
                }
            }
        }

        return false;
    } // end exits_cedula_todos()

   /**
    * is_active()
    *
    * @access public
    * @param {string} $email The members email address
    * @return {boolean}
    */
   public function is_active($cedula){
      if(isset($cedula) && $cedula != ''){
         $sql = "SELECT
            active
            FROM
            qo_members
            WHERE
            cedula = '".$cedula."'";

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               if($row["active"] == 1){
                  return true;
               }
            }
         }
      }

      return false;
   } // end is_active()

   /**
    * get_id() Returns the member id.
    *
    * @access public
    * @param {string} $email The member email address.
    * @param {string} $password (optional) The member password.
    * @param {boolean} $is_encrypted (optional) True if the password passed in is already encrypted.
    * @return {integer}
    */
   public function get_id($cedula, $password = null, $is_encrypted = false){
      if(isset($cedula) && $cedula != ''){
         $sql = "select
            id
            from
            qo_members
            where
            cedula = '".$cedula."'";

         if(isset($password) && $password != ''){
            // not encrypted? encrypt it
            if($is_encrypted == false){
               $this->os->load('security');
               // pass the member's current encrypted password as salt
               $password = $this->os->security->encrypt($password, $this->get_password($cedula));
            }
            $sql .= " AND password = '".$password."'";
         }

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return $row['id'];
            }
         }
      }

      return null;
   } // end get_id()

	/**
    * get_name() Returns the name of a member.
	 *
    * @access public
	 * @param {integer} $member_id The id of the member.
    * @return {string}
	 */
	public function get_name($member_id){
      if($member_id){
			$sql = "SELECT
				first_name,
				last_name
				FROM
				qo_members
				WHERE
				id = ".$member_id;

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return $row['first_name']." ".$row['last_name'];
            }
         }
      }

      return null;
   } // end get_name()

	/**
    * get_locale() Returns the locale of a member.
	 *
    * @access public
	 * @param {integer} $member_id
    * @return {string}
	 */
	public function get_locale($member_id){
      if(!isset($member_id) || $member_id == ''){
         return null;
      }

      $sql = "SELECT
         locale
         FROM
         qo_members
         WHERE
         id = ".$member_id;

      $result = $this->os->db->conn->query($sql);
      if($result){
         $row = $result->fetch(PDO::FETCH_ASSOC);
         if($row){
            return $row['locale'];
         }
      }

      return null;
	} // end get_locale()

   /**
    * get_password() For security reasons this needs to be private.
    * @param {string} $email
    */
   private function get_password($email){
      if(isset($email) && $email != ''){
         $sql = "SELECT
            password
            FROM
            qo_members
            WHERE
            cedula = '".$email."'";

         $result = $this->os->db->conn->query($sql);
         if($result){
            return $result->fetchColumn();
         }
      }

      return NULL;
   } // end get_password()

	/**
    * is_spam()
	 *
    * @access private
	 * @param {string} $email An email address to check
    * @return {boolean}
	 */
	public function is_spam($email){
      if(isset($email) && $email != ''){
         $sql = "SELECT
            id
            FROM
            qo_spam
            WHERE
            email_address = '".$email."'";

         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return true;
            }
         }
      }

		return false;
	} // end is_spam()

	/**
    * signup_exists()
	 *
    * @access private
	 * @param {string} $email The members email address
    * @return {boolean}
	 */
	public function signup_exists($email){
      if(isset($email) && $email != ''){
         $sql = "SELECT
            id
            FROM
            qo_members
            WHERE
            email_address = '".$email."'  AND active = 0";;
         $result = $this->os->db->conn->query($sql);
         if($result){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if($row){
               return true;
            }
         }
      }

		return false;
	} // end signup_exists()

    /**
     * signup_exists_cedula()
     *
     * @access private
     * @param {string} $cedula  The members cedula
     * @return {boolean}
     */
    public function signup_exists_cedula($cedula){
        if(isset($cedula) && $cedula != ''){
            $sql = "SELECT
            id
            FROM
            qo_members
            WHERE
            cedula = '".$cedula."'" . " AND active = 0";

            $result = $this->os->db->conn->query($sql);
            if($result){
                $row = $result->fetch(PDO::FETCH_ASSOC);
                if($row){
                    return true;
                }
            }
        }

        return false;
    } // end signup_exists()
}
?>