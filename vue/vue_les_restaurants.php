    <h2> Liste des Restaurants </h2>

    <table class="affiche-tab">
        <?php
            foreach($lesRestaurants as $unRestaurant){
                echo 
                "<tr>
                    <td><img class='images-hotel' src='images/imagesSQL/".$unRestaurant["image"]."' alt=''></td>",
                    "<td> <p class='libelle'>".$unRestaurant["libelle"]."</p><p class='adresse'>".$unRestaurant['adresse']."</p><p class='email'> ".$unRestaurant['email']."</p><p class='tel'> ".$unRestaurant['tel']."</p>",
                    "<td>".$unRestaurant["prix"]." €</td>",
                    "<td><input class='reservation' type='submit' name='reserver' value='Visiter le site'></td>",
                "</tr>";
            }
        ?>
    </table>
</main>