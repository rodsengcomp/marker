<?php
/*************************************************************************************
 * @author Rodolfo Romaioli Ribeiro de Jesus          *
 * Data: 11/06/2021                                                                  *
 * Configuração de conexão com dois bancos de dados em um único servidor.            *
 * O banco principal carrega as configurações e tabelas do ano atual.                *
 * Já o segundo banco de dados carrega os arquivos de anos anteriores se solicitado  *
 * ***********************************************************************************

/** Constantes de parâmetros para configuração da conexão */

date_default_timezone_set('America/Sao_Paulo'); // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
$today_year = date('Y');
$year = isset($_GET['ano']) ? $_GET['ano'] : $today = date("Y");
$ano_atual = date('Y'); // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$ano_anterior = $ano_atual - 1;
$ano_atual_con = date('Y'); // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$get_year_con = isset($_GET['ano']) ? $_GET['ano'] : $ano_atual_con;
$get_year = isset($_GET['ano']) ? $_GET['ano'] : $ano_atual;

class Conexao {

    const HOST = '192.168.0.26';
    const DBNAME = 'sisdam';
    const USER = 'sisdam_bdjacana';
    const PASSWORD = '3f2nY4es3UdxGA7P';
    const INDEX = 'index';

    /** Atributo estático de conexão */
    private static $pdo;

    /** Escondendo o construtor da classe */
    private function __construct() {
        //
    }

    /** Método estático para retornar uma conexão válida
     *  Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão */
    public static function getInstance(): PDO
    {
        if (!isset(self::$pdo)) {
            try {
                $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
                self::$pdo = new PDO("mysql:host=" . conexao::HOST . "; dbname=" . conexao::DBNAME . ";", conexao::USER, conexao::PASSWORD, $opcoes);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Erro: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }
}

// Criando a conexão ...
$conectar = new mysqli(conexao::HOST, conexao::USER, conexao::PASSWORD, conexao::DBNAME);

$host = conexao::HOST;
$index = conexao::INDEX;

    $sql_details = array(
        'user' => conexao::USER,
        'pass' => conexao::PASSWORD,
        'db' => conexao::DBNAME,
        'host' => conexao::HOST,
    );