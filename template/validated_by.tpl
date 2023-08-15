<link rel="stylesheet" href="{$VALIDATED_BY_PATH}css/validated_by.css">
<div class="validatedByForm">
    {if isset($VALIDATED_BY_MESSAGE)}
        <div class="{$VALIDATED_BY_MESSAGE.type}">
            {$VALIDATED_BY_MESSAGE.icon}
            <ul>
                <li>
                    {$VALIDATED_BY_MESSAGE.text}
                </li>
            </ul>

        </div>
    {/if}
    <h1>Validated By : {if $CURRENT_VALIDATED_BY === null}
            <span class="validatedBadge danger">
                Not Validated
            </span>
        {else}
            <span class="validatedBadge success">
                Validated by : {$CURRENT_VALIDATED_BY}
            </span>           
        {/if}
    </h1>
    <div class="contentValidatedBy">
        <div class="col" id="colLeft">
            <img src="{$CURRENT_IMG_VALIDATED_BY}" alt="Description de l'image">
            <p>Le plugin 'Validated By' offre une fonctionnalité supplémentaire pour renforcer la crédibilité et
                la confiance des photos au sein de votre galerie Piwigo. Il introduit un paramètre 'validated_by',
                permettant d'associer une photo à une validation spécifique.</p>
            <p>Lorsqu'il est utilisé conjointement avec l'API, ce plugin offre la possibilité de filtrer et d'afficher
                uniquement les photos qui ont été validées. Cela peut être particulièrement utile pour les galeries qui
                nécessitent une authentification ou une vérification des photos avant leur affichage public,
                garantissant
                ainsi que chaque photo répond à des normes de qualité ou d'authenticité spécifiques.</p>
        </div>
        <div class="col" id="colRight">
            <form method="post" action="">
                <strong>Validated by</strong>
                <br />
                <input type="text" id="validated_by" name="validated_by" maxlength="100"
                    placeholder="Changer le paramètre 'validated_by'">
                <p><input type="submit" value="Enregistrer les paramètres"></p>
            </form>
        </div>
    </div>
</div>