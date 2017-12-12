<?php

use Aura\Sql\ExtendedPdo;

class Helpers {

    protected $container;

    public function __construct($c) {
        $this->container = $c;
    }

    public function importMDB($file) {

        try {
            # OPEN BOTH DATABASE CONNECTIONS
            $odbc = new ExtendedPdo("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)}; DBq=$file;Uid=sa;Pwd=;");

            $pdo = $this->container['db'];
            
            $sql = "SELECT * FROM emp_attendance";
            $accstmt = $odbc->query($sql);
            $accstmt->setFetchMode(PDO::FETCH_ASSOC);

            // FETCH ROWS FROM MS ACCESS
            while($row = $odbc->fetch()) {
                // APPEND TO MYSQL
                $mystmt = $pdo->prepare("INSERT INTO emp_attendance (empid, `date`, status, notes) VALUES (?, ?, ?, ?)");

                # BIND PARAMETERS
                /*$mystmt->bindParam(1, $row['empid'], PDO::PARAM_STR, 50);
                $mystmt->bindParam(2, $row['date'], PDO::PARAM_STR, 50);
                $mystmt->bindParam(3, $row['status'], PDO::PARAM_STR, 50);
                $mystmt->bindParam(4, $row['notes'], PDO::PARAM_STR, 50);
*/

                # EXECUTE QUERY
                $mystmt->execute();
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage()."\n";
            exit;
        }

// CLOSE CONNECTIONS
        $pdo = null;
        $myConn = null;
    }
}