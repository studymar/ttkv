<?php

/* 
 */

use yii\bootstrap4\Html;
?>

    <article>
        <!-- Login -->
        <h2>Passwort vergessen</h2>
        <div>
                <!-- Anmelden Schritt 3 -->
                <div>
                    <div class="mb-3">
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill list-group-item-secondary">Passwort geändert</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex flex-row">
                        <p>
                            Dein Passwort wurde geändert, du kannst dich jetzt wieder einloggen.
                            <br/><br/>
                            <?= Html::a('Zum Login', ['account/index'],["class"=>"btn btn-primary"]) ?>
                        </p>
                    </div>
                </div>
                                
                <br/>
        </div>
                
    </article>

