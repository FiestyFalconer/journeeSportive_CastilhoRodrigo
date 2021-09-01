<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Inscription à la journée sportive du CFPT</h1>
    <form action="inscription.php" method="POST">

        <div>
            <label>Nom :</label>
            <input type="text" name="nomEleve">
        </div>

        <div>
            <label>Prenom :</label>
            <input type="text" name="prenomEleve">
        </div>

        <div>
            <label>Classe :</label>
        </div>

        <div>
            <p>---------------------------------------------------------</p>
        </div>

        <div>
            <label>Premier choix:</label>
            <select name="premierChoix">
                <option value="accrobranche">Accrobranche</option>
                <option value="velo">Vélo</option>
                <option value="football">Football</option>
            </select>
        </div>

        <div>
            <label>Deuxième choix:</label>
            <select name="deuxiemeChoix">
                <option value="accrobranche">Accrobranche</option>
                <option value="velo">Vélo</option>
                <option value="football">Football</option>
            </select>
        </div>

        <div>
            <label>Troisième choix:</label>
            <select name="troisiemeChoix">
                <option value="accrobranche">Accrobranche</option>
                <option value="velo">Vélo</option>
                <option value="football">Football</option>
            </select>
        </div>

        <button type="submit" name="submit">Confirmer</button>
        <button type="submit" name="annuler">Annuler</button>

    </form>
</body>

</html>