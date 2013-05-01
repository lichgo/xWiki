<?php
/****************************************************************************** 
 * File:  05-query.php
 * 
 * Copyright (C) 2010, Apache License 2.0 
 * The Institute for System Programming of the Russian Academy of Sciences
 *  
 * This is an example application that works with Sedna XML DBMS through 
 * PHP API using sedna module. The application opens a session to the "testdb"
 * database and loads a simple document from the file into it. A simple query is
 * executed and document is dropped to make this example runnable multiple
 * times.
 *
 * Note! Before running this example make sure that Sedna server is running on
 * localhost:5050 and 'testdb' database is started:
 *
 * se_gov
 * se_cdb testdb
 * se_sm testdb
 *****************************************************************************/

$query = $_POST['query'];;
 
/* Don't print anything. We'll handle errors ... */
ini_set("sedna.verbosity","0");

/* Parameters of the database to connect to.
 * The default port is 5050. If Sedna server is listening
 * on the different port (say 5051) modify host value like:
 * $host = 'localhost:5051' */
$host      = 'localhost';
$database  = 'wiki';
$user      = 'SYSTEM';
$password  = 'MANAGER';

/* Try to connect to the testdb on the localhost with default credentials */
$conn = sedna_connect($host,$database,$user,$password);

if(!$conn) die('Could not connect: ' . sedna_error() . "\n");

/* Get file to load as a string */
// $path = dirname(__FILE__) . '/data/categories.xml';
// $file = file_get_contents($path);
// if(!$file) die('Could not read file to load: ' . $path . "\n");

/* Load a simple document from the file into the database */
// if(!sedna_load($file, 'categories'))
//     die('Could not load the document: ' . sedna_error() . "\n");

/* Execute query: list all categories in the document */
if(!sedna_execute("index-scan('by-title','" . $query . "','EQ')"))
  die('Could not execute query: ' . sedna_error() . "\n");
    
/* Print results */
$categories = sedna_result_array();
if(!$categories) 
    die('Could not get query result or result is empty: ' . sedna_error() . "\n");

foreach($categories as $key => $cat)
  // echo str_replace('&gt;','>', str_replace('&lt;', '<', $cat));  
    echo $cat;
/* Remove the document */
//if(!sedna_execute('drop document "categories"'))
  //  die('Could not drop the document: ' . sedna_error() . "\n");

/* Properly close the connection */
if(!sedna_close($conn)) 
    die('Could not close connection:' . sedna_error() . "\n");
?>
