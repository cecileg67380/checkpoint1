<?php
require_once './connect.php';
$pdo=new \PDO(DSN, USER, PASS);
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                Add a bribe
                <?php
                if (isset($_POST['bribe_submit'])) {
                    $bribe_name = trim($_POST['bribe_name']);
                    $bribe_payment = trim($_POST['bribe_payment']);
                require_once './connect.php';
                // je crée ma PHP database Objects nommee PDO
                $pdo=new \PDO(DSN, USER, PASS);
                    $query = "INSERT INTO bride (bribe_name, bribe_payment) VALUES (:bribe_name, :bribe_payment)";
                    $statement = $pdo->prepare($query);

                    $statement->bindValue(':bribe_name', $bribe_name, PDO::PARAM_STR);
                    $statement->bindValue(':bribe_payment', $bribe_payment, PDO::PARAM_INT);

                    $statement->execute();
                }

                ?>
                <form action="" method="post">
                    <div>
                        <label for="bribe_name">Name</label>
                        <input type="text" id="bribe_name" name="bribe_name" required="required" >
                    </div>
                    <div>
                        <label for="bribe_payment">Payment</label>
                        <input type="number" id="bribe_payment" name="bribe_payment" required="required" >
                    </div>
                    <div class="button">
                        <button type="submit" name="bribe_submit">Pay!</button>
                    </div>
                </form>
            </div>

            <div class="page rightpage">

                <?php
                if (isset($_POST['bribe_submit'])) {
                require_once './connect.php';
                $pdo=new \PDO(DSN, USER, PASS);
                //je construits ma requete
                $query = "SELECT name, payment FROM bribe ORDER BY name";
                $statement = $pdo->query($query);
                $bribes = $statement->fetchAll();
                }
                ?>
                <!-- voici mon tableau : Display bribes and total paiement -->
                <table class="cg-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Payment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_POST['bribe_name'])) {
                        foreach ($bribes as $key => $value) { //voir si cest pas ($bribes as $bride)
                            echo "<tr>";
                            echo "<td>" . $value['name'] . "</td>";
                            echo "<td>" . $value['payment'] . "</td>";
                            echo "</tr>";
                        }
                    }else{
                       echo "<tr>";
                       echo "<td colspan='2'>No payment registred</td>";
                       echo "</tr>";
                   }
                    ?>
                    </tbody>
                    <tfoot>
                        <th>Total</th>
                        <?php
                        require_once './connect.php';
                        $pdo=new \PDO(DSN, USER, PASS);
                        //je construits ma requete pour informer de la somme TOTALE de mes paiements
                        $query = "SELECT SUM(payment) AS total_payment FROM bribe";
                        $statement = $pdo->query($query);
                        $bribes = $statement->fetchAll();
                        echo"<td>". $bribes['total_payment']  ."</td>";
                        

                        ?>
                    </tfoot>
                </table>

            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
