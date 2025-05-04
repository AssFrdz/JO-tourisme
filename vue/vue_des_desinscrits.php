<h2>Administration des désinscriptions</h2>

<p><?php 
if(!empty($_SESSION["msg"])){
    echo $_SESSION["msg"];
}

var_dump($_SESSION["vue_desinscrits"]);
?></p>

<table class="vueAdmin">
    <thead>
    <tr>
        <th>Id de l'user</th>
        <th>Date de la demande</th>
        <th>Motif de l'user</th>
        <th>Statut</th>
        <th>Réservation</th>
        <th>Motif de l'administrateur</th>
        <th>Accepter</th>
        <th>Refuser</th>


    </tr>
    </thead>

    <tbody>
        <?php foreach($_SESSION["vue_desinscrits"] as $ligne):?>
            <form action="" method="post">
                <tr>
                <td><input type="hidden" name="id_user" value="<?=$ligne["id_user"]?>"><?=$ligne["id_user"]?></td>
            <td><?=$ligne["dateD"]?></td>
            <td><?=$ligne["motif_User"]?></td>
            <td><?=$ligne["statut"]?></td>
            <td><?php if($ligne["reservation"]==1){
                echo "Réservations en cours";
            }else{
                echo "Pas de réservations";
            }
            ?></td>
            <td><textarea name="motif_Admin" id="" cols="30" rows="10">
            <?=$ligne["motif_Admin"]?>
            </textarea>
            </td>
            <?php if($ligne["statut"]=="Acceptée"):?>
            <td>Plus de compte</td>
            <td>Plus de compte</td>
            <?php else:?>
            <td><button name="accepter" type="submit"><i class="fa-solid fa-check" style="color: #63E6BE;"></i></button></td>
            <td><button name="refuser" type="submit"><i class="fa-solid fa-xmark" style="color: #a80032;"></i></button></td>
            <?php endif;?>
                </tr>
            
        </form>
        <?php endforeach;?>
    </tbody>
    
</table>