<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

/**
 * Database Column Object
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version        $Revision$
 * @since        owa 1.0.0
 */
 
class owa_dbColumn {

     var $name;

     var $value;

     var $data_type;

     var $foreign_key;

     var $is_primary_key = false;

     var $auto_increment = false;

     var $is_unique = false;

     var $is_not_null = false;

     var $label;

     var $index;

     var $default_value;

     function __construct($name ='', $data_type = '') {

         if ($name) {
             $this->setName($name);
         }

         if ($data_type) {
             $this->setDataType($data_type);
         }
       
     }

     function get($name) {

         return $this->$name;
     }

     function set($name, $value) {

         $this->$name = $value;

         return;
     }

     function getValue() {

         return $this->value;
     }

     function setValue($value) {

         $this->value = $value;

         return;
     }

     function getDefinition() {

         $definition = '';

         $definition .= $this->get('data_type');

        // Check for auto Not null
        if ($this->get('is_not_null') == true):
            $definition .= ' '.OWA_DTD_NOT_NULL;
        endif;

        // check for primary key
        if ($this->get('is_primary_key') == true):
            $definition .= ' '.OWA_DTD_PRIMARY_KEY;
        endif;

        // check for index
        if ($this->get('index') == true && defined('OWA_SQL_INLINE_INDEX')):
            $definition .= sprintf(", ".OWA_SQL_INLINE_INDEX, $this->get('name'));
        endif;

         return $definition;

     }

     function setDataType($type) {

         $this->data_type = $type;
         
         // OWA_DTD_SERIAL is thepsuedao datatype sued for autoincrement columns
         // in MySQL and PostgreSQL.
         if ($type === OWA_DTD_SERIAL) {
             $this->auto_increment = true;
         }         
     }

     function setDefaultValue($value) {

         $this->default_value = $value;
     }

     function setPrimaryKey() {

         $this->is_primary_key = true;
     }

     function setIndex() {

         $this->index = true;
     }

     function setNotNull() {

         $this->is_not_null = true;
     }

    function setUnique() {

         $this->is_unique = true;
     }

     function setLabel($label) {

         $this->label = $label;
     }

     function setForeignKey($entity, $column = 'id') {

         $this->foreign_key = array($entity, $column);
     }

     function getForeignKey() {

         return $this->foreign_key;
     }

     function isForeignKey() {

         if (!empty($this->foreign_key)) {
             return true;
         } else {
             return false;
         }
     }

     function setName($name) {

         $this->name = $name;
     }

     function getName() {

         return $this->name;
     }

 }

?>