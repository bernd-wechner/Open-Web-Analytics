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
// 2020 - Bernd Wechner
//
// This postgresql support based on:
//
// https://www.convert-in.com/mysql-to-postgres-types-mapping.htm
// 
// and other cited references
//
// $Id$
//

define('OWA_DTD_BIGINT', 'BIGINT');      // Unchanged
define('OWA_DTD_INT', 'INT');            // Unchanged
define('OWA_DTD_TINYINT', 'SMALLINT');   // Was TINYINT(1)
define('OWA_DTD_TINYINT2', 'SMALLINT');  // Was TINYINT(2)
define('OWA_DTD_TINYINT4', 'SMALLINT');  // Was TINYINT(4)

// See https://dev.mysql.com/doc/refman/8.0/en/numeric-type-syntax.html
// SERIAL is an alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE.
// This is used in only one place, in the owa_user constructor and
// That line is a candidate for bringing into conformance with other
// constants herein and dispelling with this one as it is a MySQL 
// specific alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE
// and not portable across database engines.
define('OWA_DTD_SERIAL', 'BIGSERIAL');         // Was SERIAL

// Primary Key syntax appears same as MySQLs
// https://dev.mysql.com/doc/refman/8.0/en/partitioning-limitations-partitioning-keys-unique-keys.html
// https://www.postgresqltutorial.com/postgresql-primary-key/
define('OWA_DTD_PRIMARY_KEY', 'PRIMARY KEY');   // Unchanged

define('OWA_DTD_VARCHAR10', 'VARCHAR(10)');     // Unchanged
define('OWA_DTD_VARCHAR255', 'VARCHAR(255)');   // Unchanged
define('OWA_DTD_VARCHAR', 'VARCHAR(%s)');       // Unchanged

define('OWA_DTD_TEXT', 'TEXT');                 // Was MEDIUMTEXT
define('OWA_DTD_BOOLEAN', 'BOOLEAN');           // Was TINYINT(1)

define('OWA_DTD_TIMESTAMP', 'TIMESTAMP');       // Unchanged

define('OWA_DTD_BLOB', 'BYTEA');                // Was BLOB

/** Unsure of this one
 *  codecheck reveals it is used nowhere outside of getDefintion and then only
 *  if a column has index set.
 *  
 * There is however  a suspicious line in getDefntion:
 * 
 * $definition .= sprintf(", INDEX (%s)", $this->get('name'));
 * 
 * That DOES NOT use a constant herein and looks very suspisciuously liek it should!
 * 
 * It's hard to determin wher eindex is set as it's such ageneric term with 
 * many code hits. But one place it's clearly used is in addIndex() and code 
 * samples include:
 * 
 *  $db->addIndex($table, 'yyyymmdd');
 *  $db->addIndex( $table, 'site_id' );
 *  $db->addIndex( $table, 'session_id' );
 *  $db->addIndex( 'owa_action_fact', 'action_group, action_name' );
 *  $db->addIndex( 'owa_commerce_transaction_fact', 'yyyymmdd' );
 *  $db->addIndex( 'owa_commerce_line_item_fact', 'yyyymmdd' );
 *  $db->addIndex( 'owa_queue_item', 'status' );
 *  $db->addIndex( 'owa_queue_item', 'event_type' );
 *  $db->addIndex( 'owa_queue_item', 'not_before_timestamp' );
 *  $db->addIndex( 'owa_domstream', 'yyyymmdd' );
 *  $db->addIndex( 'owa_domstream', 'domstream_guid' );
 *  $db->addIndex( 'owa_domstream', 'document_id' );             
 */

define('OWA_DTD_INDEX', 'KEY');             // Unchanged

/** Unsure of this one (codecheck needed)
 *  https://www.tutorialspoint.com/postgresql/postgresql_using_autoincrement.htm
 *  Seems MySQL uses a qualifier, and Postgresql a datatype (BIGSERIAL)
 *  
 *  Context of use: 
 *      Used only in getDefinition()
 *      Which is used only in getColumnDefinition
 *      Which is used in createTable()
 *          and addColumn, modifyColumn, renameColumn
 *          
 *      It's only used if the debcolumn has the attribute 
 *      auto_increment set. It is only ever set with setAutoIncrement()
 *      which in turn is never explcity called anywhere.
 *          
 *   Needs further study. It looks like no column is ever set  
 *   with OWA_DTD_AUTO_INCREMENT.
 *   
 *   Bottom line is we get away with
 *   and empty string here but this presupposes that it's
 *   only used on OWA_DTD_SERIAL columns.
 */ 
define('OWA_DTD_AUTO_INCREMENT', 'AUTO_INCREMENT');

define('OWA_DTD_NOT_NULL', 'NOT NULL');         // Unchanged

/**
 * Unsure of this one
 * 
 * codecheck reveals it is used only in getDefinition() and only if the
 * column defintion has is_unique set. But is_unique is not referneced 
 * anywhere in the code base and moreover where this is used it provides
 * no data for the %s that was configured.
 * 
 * Hypothesis: an unused setting, either deprecated legacy or intended
 * for possible future use. But can be safely ignored.
*/ 
define('OWA_DTD_UNIQUE', 'UNIQUE');    // Was PRIMARY KEY(%s)

// These all unchanged, as appear to be standard SQL
define('OWA_SQL_ADD_COLUMN', 'ALTER TABLE %s ADD %s %s');   
define('OWA_SQL_DROP_COLUMN', 'ALTER TABLE %s DROP %s');
define('OWA_SQL_RENAME_COLUMN', 'ALTER TABLE %s CHANGE %s %s %s'); 
define('OWA_SQL_MODIFY_COLUMN', 'ALTER TABLE %s MODIFY %s %s'); 
define('OWA_SQL_RENAME_TABLE', 'ALTER TABLE %s RENAME %s'); 
define('OWA_SQL_CREATE_TABLE', 'CREATE TABLE IF NOT EXISTS %s (%s) %s'); 
define('OWA_SQL_DROP_TABLE', 'DROP TABLE IF EXISTS %s');  
define('OWA_SQL_INSERT_ROW', 'INSERT into %s (%s) VALUES (%s)');
define('OWA_SQL_UPDATE_ROW', 'UPDATE %s SET %s %s');
define('OWA_SQL_DELETE_ROW', "DELETE from %s %s");
define('OWA_SQL_CREATE_INDEX', 'CREATE INDEX %s ON %s (%s)');
define('OWA_SQL_DROP_INDEX', 'DROP INDEX %s ON %s');
define('OWA_SQL_INDEX', 'INDEX (%s)');
define('OWA_SQL_BEGIN_TRANSACTION', 'BEGIN');
define('OWA_SQL_END_TRANSACTION', 'COMMIT');

/** It appears ENGINE is a MySQL only concept with no Postgresql equivalent:
 *      https://www.quora.com/What-is-the-equivalent-of-MySQL-engines-in-PostgreSQL?share=1
 *      
 * Used only in createTable() and only relevant if MEMORY type uis requested
 * Which Postgresqle doesn't support.
 * 
 * That in turn is used only in getTableOptions().
 * 
 * alterTableType uses OWA_SQL_ALTER_TABLE_TYPE but that is used in only one
 * place:
 * 
 * $ret = $db->alterTableType($this->c->get('base', 'ns').$v, 'InnoDB');
 * 
 * We are probably sage nulling these all out.
 * 
 * May need a code change to respect the nulled value as I suspect, this
 * 
 *  $table_options .= sprintf(OWA_DTD_TABLE_TYPE, $table_type);
 *  
 *  will crash.
 */ 
define('OWA_DTD_TABLE_TYPE', '');                       // Was ENGINE = %s
define('OWA_DTD_TABLE_TYPE_DEFAULT', '');               // Was INNODB
define('OWA_DTD_TABLE_TYPE_DISK', '');                  // Was INNODB
define('OWA_DTD_TABLE_TYPE_MEMORY', '');                // Was MEMORY
define('OWA_SQL_ALTER_TABLE_TYPE', '');                 // Was ALTER TABLE %s ENGINE = %s

// All unchanged as appear to be standard SQL
define('OWA_SQL_JOIN_LEFT_OUTER', 'LEFT OUTER JOIN');
define('OWA_SQL_JOIN_LEFT_INNER', 'LEFT INNER JOIN');
define('OWA_SQL_JOIN_RIGHT_OUTER', 'RIGHT OUTER JOIN');
define('OWA_SQL_JOIN_RIGHT_INNER', 'RIGHT INNER JOIN');
define('OWA_SQL_JOIN', 'JOIN');
define('OWA_SQL_DESCENDING', 'DESC');
define('OWA_SQL_ASCENDING', 'ASC');

// Likely compatibility issues.
// Needs code check.
define('OWA_SQL_REGEXP', 'REGEXP');
define('OWA_SQL_NOTREGEXP', 'NOT REGEXP');

// Unchanged as appear to be standard SQL
define('OWA_SQL_LIKE', 'LIKE');

// See OWA_DTD_INDEX above. Needs to be ckeched for PostgreSQL compatibility
define('OWA_SQL_ADD_INDEX', 'ALTER TABLE %s ADD INDEX (%s) %s');

// All unchanged as appear to be standard SQL
define('OWA_SQL_COUNT', 'COUNT(%s)');
define('OWA_SQL_SUM', 'SUM(%s)');
define('OWA_SQL_ROUND', 'ROUND(%s)');
define('OWA_SQL_AVERAGE', 'AVG(%s)');
define('OWA_SQL_DISTINCT', 'DISTINCT %s');
define('OWA_SQL_DIVISION', '(%s / %s)');

/** Used only in createTable to set a table option
 * 
 * $table_options .= sprintf(' ' . OWA_DTD_TABLE_CHARACTER_ENCODING, $options['character_encoding']);
 * 
 * PostgreSQL does not set encoding on a table basis however but only for a whole database at time of
 * of database ceation. It also 
 * 
 * See: https://www.postgresql.org/docs/9.3/multibyte.html
 * 
 *  UTF8 is the default in any case. Checked all my existing databases with "psql -l" and they are
 *  all UTF8. So Suspect we can just null these out.
 *  
 *   May need a code change to respect the nulled value as I suspect the line above will crash. 
 */
define('OWA_DTD_CHARACTER_ENCODING_UTF8', '');    // Was utf8
define('OWA_DTD_TABLE_CHARACTER_ENCODING', '');   // Was CHARACTER SET = %s


/**
 * PostgreSQL Data Access Class
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>, Bernd Wechner <bwechner@yahoo.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version     $Revision$
 * @since        owa 1.0.0
 */

// Codecheck  needed to see where this is used
// Why the persistent spelling mistake: persistant?
class owa_db_postgresql extends owa_db {

    function connect() {

        if ( ! $this->connection ) {
            $host = $this->getConnectionParam('host');           

            if ($this->getConnectionParam('port')) {
                $port = $this->getConnectionParam('port');
            } else {
                $port = 5432;
            }

            // get a connection (explicitly set the character set as UTF-8)
            // see: https://stackoverflow.com/questions/18250167/how-set-utf-8-in-pdo-class-constructor-for-php-pgsql-database#26619837
            $conn_string = sprintf("host=%s port=%s user=%s password=%s dbname=%s options='--client_encoding=UTF8'", 
                                    $host,
                                    $this->getConnectionParam('user'),
                                    $this->getConnectionParam('password'),
                                    $this->getConnectionParam('name'),
                                    $port);
            
            // Make a persistent connection if need be.
            // Note: persistent connections are questionable to begin with:
            //     https://www.php.net/manual/en/features.persistent-connections.php
            if ( $this->getConnectionParam('persistant') ) {
                $this->connection = pg_pconnect($conn_string);
            } else {
                $this->connection = pg_connect($conn_string);
            }
            
        }

        if ( ! $this->connection ) {

            $this->e->alert('Could not connect to database.');
            $this->connection_status = false;
            return false;

        } else {

            $this->connection_status = true;
            return true;
        }
    }


    /**
     * Database Query
     *
     * @param     string $sql
     * @access     public
     *
     */
    function query( $sql ) {
  
          if ( $this->connection_status == false) {

              owa_coreAPI::profile($this, __FUNCTION__, __LINE__);

              $this->connect();

              owa_coreAPI::profile($this, __FUNCTION__, __LINE__);
          }
  
          owa_coreAPI::profile($this, __FUNCTION__, __LINE__);

        $this->e->debug(sprintf('Query: %s', $sql));

        $this->result = array();

        $this->new_result = '';

        if ( ! empty( $this->new_result ) ) {

            pg_free_result($this->new_result);
        }

        owa_coreAPI::profile($this, __FUNCTION__, __LINE__, $sql);

        $result = @pg_query( $this->connection, $sql );

        owa_coreAPI::profile($this, __FUNCTION__, __LINE__);
        // Log Errors

        if ( pg_result_error( $result ) ) {

            $this->e->debug(
                sprintf(
                    'A PostgreSQL error ocured. Error: (%s) %s. Query: %s',
                    pg_result_status( $result ),
                    htmlspecialchars( pg_result_error( $result ) ),
                    $sql
                )
            );
        }

        owa_coreAPI::profile($this, __FUNCTION__, __LINE__);

        $this->new_result = $result;

        return $this->new_result;
    }

    function close() {

        @pg_close( $this->connection );
    }

    /**
     * Fetch result set array
     *
     * @param     string $sql
     * @return     array
     * @access  public
     */
    function get_results( $sql ) {

        if ( $sql ) {

            $this->query($sql);
        }

        if (!$this->new_result) {
            return null;
        }

        while ( $row = pg_fetch_assoc( $this->new_result ) ) {

            array_push($this->result, $row);

        }

        if ( $this->result ) {

            return $this->result;

        } else {

            return null;
        }
    }

    /**
     * Fetch Single Row
     *
     * @param string $sql
     * @return array
     */
    function get_row($sql) {

        $this->query($sql);

        $row = @pg_fetch_assoc($this->new_result);

        return $row;
    }

    /**
     * Prepares and escapes string
     *
     * @param string $string
     * @return string
     */
    function prepare( $string ) {

        if ($this->connection_status == false) {
              $this->connect();
          }

          return pg_escape_string( $this->connection, $string );

    }

    // Note: Unlike the MySQL equivalent pg_affected_rows need a result.
    // We shoudl pass this in as an argument but for now just assume it's
    // the one the last query produced above. Codecheck needed.
    function getAffectedRows() {

        return pg_affected_rows($this->new_result);
    }
}

?>