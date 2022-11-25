<?php
/**
 * Plugin Name:       PalabrasMalsonantesDB
 * Description:       Cambia las palabras malsonantes por otras menos malsonantes
 * Version:           1.0
 * Author:            Nuria Garcia Cobas
 */


function crearTablas() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$table_name1 = $wpdb->prefix . 'palabras_malsonantes';
	$table_name2 = $wpdb->prefix . 'palabras_reemplazo';
	//$sq = "DROP TABLE $table_name1 IF EXISTS;";
   // $sq1 = "DROP TABLE $table_name2 IF EXISTS;";
	$sql = "CREATE TABLE $table_name1 (
        id mediumint(9) NOT NULL,
        palabra text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

	$sql2 = "CREATE TABLE $table_name2 (
        id mediumint(9) NOT NULL,
        palabra text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql );
	dbDelta( $sql2 );
}

add_action( 'plugins_loaded', 'crearTablas' );


function insertValoresTablas() {
	global $wpdb;
	$table_name1 = $wpdb->prefix . 'palabras_malsonantes';
	$table_name2 = $wpdb->prefix . 'palabras_reemplazo';
	
	$sql11 = "INSERT INTO $table_name1 (id, palabra) VALUES (1, 'caca')";
	$sql12 = "INSERT INTO $table_name1 (id, palabra) VALUES (2, 'culo')";
	$sql13 = "INSERT INTO $table_name1 (id, palabra) VALUES (3, 'pedo')";
	$sql14 = "INSERT INTO $table_name1 (id, palabra) VALUES (4, 'pis')";
	$sql15 = "INSERT INTO $table_name1 (id, palabra) VALUES (5, 'piroca')";

	$sql21 = "INSERT INTO $table_name2 (id, palabra) VALUES (1, 'popo')";
	$sql22 = "INSERT INTO $table_name2 (id, palabra) VALUES (2, 'pompis')";
	$sql23 = "INSERT INTO $table_name2 (id, palabra) VALUES (3, 'ventosillo')";
	$sql24 = "INSERT INTO $table_name2 (id, palabra) VALUES (4, 'pipi')";
	$sql25 = "INSERT INTO $table_name2 (id, palabra) VALUES (5, 'pito')";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( $sql11 );
	dbDelta( $sql12 );
	dbDelta( $sql13 );
	dbDelta( $sql14 );
	dbDelta( $sql15 );

	dbDelta( $sql21 );
	dbDelta( $sql22 );
	dbDelta( $sql23 );
	dbDelta( $sql24 );
	dbDelta( $sql25 );
}

add_action( 'plugins_loaded', 'insertValoresTablas' );


function reescribir_malsonantes( $text ) {
	global $wpdb;
	$table_malsonantes = $wpdb->prefix . 'palabras_malsonantes';
	$table_reemplazo   = $wpdb->prefix . 'palabras_reemplazo';

	$malsonantes = $wpdb->get_results( "SELECT palabra FROM $table_malsonantes", ARRAY_A);
	$reemplazos  = $wpdb->get_results( "SELECT palabra FROM $table_reemplazo", ARRAY_A);

	//$malsonantes = dbDelta("SELECT text FROM $table_malsonantes");
	//$reemplazos = dbDelta("SELECT text FROM $table_reemplazo");
	$malsonante = array();
	foreach ( $malsonantes as $row) {
		$malsonante[] =$row['palabra'];
//hacer algo con $receptor y $nombre porque en la siguiente iteración serán sobreescritos
	}
	$reemplazo = array();
	foreach($reemplazos as $row1) {
		$reemplazo []=$row1['palabra'];
        error_log("Recorremos resultado: " . $row1['palabra']);
	}

	return str_replace( $malsonante, $reemplazo, $text );
}

add_filter( 'the_content', 'reescribir_malsonantes' );
?>