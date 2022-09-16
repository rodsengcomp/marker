<?php

// SQL server connection information
include_once '../../conexao.php';

/*
* Funções auxiliares para a construção de uma consulta SQL de processamento do lado do servidor DataTables
 *
 * As funções estáticas nesta classe são apenas funções auxiliares para ajudar a construir
 * O SQL usado nos scripts de processamento de servidor de demonstração DataTables. Estes
 * Funções, obviamente, não representam tudo o que pode ser feito com o lado do servidor
 * Processamento, eles são intencionalmente simples de mostrar como isso funciona. Mais complexo
 * As operações de processamento do lado do servidor provavelmente exigirão um script personalizado.
 *
 * Veja http://datatables.net/usage/server -side para detalhes completos no servidor-
 * Requisitos de processamento de lado da DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

    class SSP {
    /**
     * Crie a matriz de saída de dados para as linhas de DataTables
     *
     * @param array $ columns Argumento da informação da coluna
     * @param array $ dados Dados do SQL get
     * @return array Dados formatados em um formato baseado em linha
     */
    static function data_output($columns, $data)
    {
        $out = array();
        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();
            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                }
            }
            $out[] = $row;
        }
        return $out;
    }

    /**
     * Conexão de banco de dados
     *
     * Obter uma conexão PDO do PHP a partir de uma matriz de detalhes da conexão
     *
     * @param array $ conn SQL detalhes da conexão. A matriz deve ter
     * As seguintes propriedades
     * * Host - nome do host
     * * Db - nome do banco de dados
     * * Usuário - nome de usuário
     * * Pass - senha do usuário
     * Conexão de PDO do recurso @return
     */
    static function db($conn)
    {
        if (is_array($conn)) {
            return self::sql_connect($conn);
        }
        return $conn;
    }

    /**
     * Paginação
     *
     * Construir a cláusula LIMIT para consulta no SQL do SQL Server
     *
     * @param array $ request Dados enviados ao servidor por DataTables
     * @param array $ columns Argumento da informação da coluna
     * @return string SQL limit clause
     */
    static function limit($request, $columns)
    {
        $limit = '';
        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . (int)$request['start'] . ", " . (int)$request['length'];
        }
        return $limit;
    }

    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @return string SQL order by clause
     */
    static function order($request, $columns)
    {
        $order = '';
        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');
            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = (int)$request['order'][$i]['column'];
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['orderable'] === 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }
            $order = 'ORDER BY ' . implode(', ', $orderBy);
        }
        return $order;
    }

    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @param  array $bindings Array of values for PDO bindings, used in the
     *    sql_exec() function
     * @return string SQL where clause
     */
    static function filter($request, $columns, &$bindings)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');
        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['searchable'] === 'true') {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $globalSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                }
            }
        }
        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                $str = $requestColumn['search']['value'];
                if ($requestColumn['searchable'] === 'true' &&
                    $str != ''
                ) {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $columnSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                }
            }
        }
        // Combine the filters into a single string
        $where = '';
        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }
        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }
        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }
        return $where;
    }

    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array|PDO $conn PDO connection resource or connection parameters array
     * @param  string $table SQL table to query
     * @param  string $primaryKey Primary key of the table
     * @param  array $columns Column information array
     * @return array          Server-side processing response array
     */
    static function simple($request, $conn, $table, $primaryKey, $columns)
    {
        $bindings = array();
        $db = self::db($conn);
        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);
        // Main query to actually get the data
        $data = self::sql_exec($db, $bindings,
            "SELECT `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 FROM $table
			 $where
			 $order
			 $limit"
        );
        // Data set length after filtering
        $resFilterLength = self::sql_exec($db, $bindings,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   $table
			 $where"
        );
        $recordsFiltered = $resFilterLength[0][0];
        // Total data set length
        $resTotalLength = self::sql_exec($db,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   $table"
        );
        $recordsTotal = $resTotalLength[0][0];
        /*
         * Output
         */
        return array(
            "draw" => isset ($request['draw']) ?
                (int)$request['draw'] :
                0,
            "recordsTotal" => (int)$recordsTotal,
            "recordsFiltered" => (int)$recordsFiltered,
            "data" => self::data_output($columns, $data)
        );
    }

    /**
     * A diferença entre este método e o `simple` é que você pode
     * Aplique condições adicionais `where` às consultas SQL. Estes podem estar em
     * Uma das duas formas:
     *
     * * 'Condição do resultado' - isto é aplicado ao conjunto de resultados, mas não o
     * Consulta global de informações de paginação - ou seja, não afetará o número
     * De registros que um usuário vê que podem ter acesso. Isso deve ser
     * Usado quando você deseja aplicar uma condição de filtragem que o usuário enviou.
     * * 'Todas as condições' - Isso é aplicado a todas as consultas feitas e
     * Reduz o número de registros que o usuário pode acessar. Isso deve ser
     * Usado em condições em que você não deseja que o usuário tenha acesso a
     * Registros particulares (por exemplo, restrição por um ID de login).
     *
     * @param array $ request Dados enviados ao servidor por DataTables
     * Matriz @param | PDO $ conn Dispositivo de conexão PDO ou matriz de parâmetros de conexão
     * @param string $ table Tabela SQL para consulta
     * @param string $ primaryKey Chave primária da tabela
     * @param array $ columns Argumento da informação da coluna
     * @param string $ whereResult WHERE condição para aplicar ao conjunto de resultados
     * @param string $ whereToda condição WHERE para aplicar a todas as consultas
     * Matriz @return array de respostas de processamento do lado do servidor
     */
    static function complex($request, $conn, $table, $primaryKey, $columns, $whereResult = null, $whereAll = null)
    {
        $bindings = array();
        $db = self::db($conn);
        $localWhereResult = array();
        $localWhereAll = array();
        $whereAllSql = '';
        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);
        $whereResult = self::_flatten($whereResult);
        $whereAll = self::_flatten($whereAll);
        if ($whereResult) {
            $where = $where ?
                $where . ' AND ' . $whereResult :
                'WHERE ' . $whereResult;
        }
        if ($whereAll) {
            $where = $where ?
                $where . ' AND ' . $whereAll :
                'WHERE ' . $whereAll;
            $whereAllSql = 'WHERE ' . $whereAll;
        }
        // Main query to actually get the data
        $data = self::sql_exec($db, $bindings,
            "SELECT `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 FROM $table
			 $where
			 $order
			 $limit"
        );
        // Data set length after filtering
        $resFilterLength = self::sql_exec($db, $bindings,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   $table
			 $where"
        );
        $recordsFiltered = $resFilterLength[0][0];
        // Total data set length
        $resTotalLength = self::sql_exec($db, $bindings,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   $table " .
            $whereAllSql
        );
        $recordsTotal = $resTotalLength[0][0];
        /*
         * Output
         */
        return array(
            "draw" => isset ($request['draw']) ?
                (int)$request['draw'] :
                0,
            "recordsTotal" => (int)$recordsTotal,
            "recordsFiltered" => (int)$recordsFiltered,
            "data" => self::data_output($columns, $data)
        );
    }

    /**
     * Conecte-se ao banco de dados
     *
     * @param array $ sql_details Conjunto de detalhes da conexão do servidor SQL, com o
     * Propriedades:
     * * Host - nome do host
     * * Db - nome do banco de dados
     * * Usuário - nome de usuário
     * * Pass - senha do usuário
     * @return PDO Database connection handle
     */
    static function sql_connect($sql_details)
    {
        try {
            $db = @new PDO(
                "mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
                $sql_details['user'],
                $sql_details['pass'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (PDOException $e) {
            self::fatal(
                "An error occurred while connecting to the database. " .
                "The error reported by the server was: " . $e->getMessage()
            );
        }
        return $db;
    }

    /**
     * Execute an SQL query on the database
     *
     * @param  resource $db Database handler
     * @param  array $bindings Array of PDO binding values from bind() to be
     *   used for safely escaping strings. Note that this can be given as the
     *   SQL query string if no bindings are required.
     * @param  string $sql SQL query to execute.
     * @return array         Result from the query (all rows)
     */
    static function sql_exec($db, $bindings, $sql = null)
    {
        // Argument shifting
        if ($sql === null) {
            $sql = $bindings;
        }
        $stmt = $db->prepare($sql);
        //echo $sql;
        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        // Execute
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            self::fatal("An SQL error occurred: " . $e->getMessage());
        }
        // Return all
        return $stmt->fetchAll(PDO::FETCH_BOTH);
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */
    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    static function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg
        ), JSON_THROW_ON_ERROR);
        exit(0);
    }

    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param  array &$a Array of bindings
     * @param  *      $val  Value to bind
     * @param  int $type PDO field type
     * @return string       Bound key to be used in the SQL where this parameter
     *   would be used.
     */
    static function bind(&$a, $val, $type)
    {
        $key = ':binding_' . count($a);
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );
        return $key;
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param  array $a Array to get data from
     * @param  string $prop Property to read
     * @return array        Array of property values
     */
    static function pluck($a, $prop)
    {
        $out = array();
        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }

    /**
     * Return a string from an array or a string
     *
     * @param  array|string $a Array to join
     * @param  string $join Glue for the concatenation
     * @return string Joined string
     */
    static function _flatten($a, $join = ' AND ')
    {
        if (!$a) {
            return '';
        }

        if ($a && is_array($a)) {
            return implode($join, $a);
        }
        return $a;
    }
}