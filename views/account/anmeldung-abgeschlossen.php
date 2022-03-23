<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

    <article>
        <!-- Login -->
        <h2>Anmeldung zur Vereinsmeldung</h2>
        <div>
                <!-- Anmelden Schritt 3 -->
                <div>
                    <div class="mb-3">
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item flex-fill list-group-item-secondary">Anmeldung abgeschlossen</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex flex-row">
                        <p>
                            Geschafft! 
                            <br>
                            Deine Email ist jetzt bestätigt. Du kannst dich jetzt einloggen.
                            <br>
                            <?= \yii\bootstrap4\Html::a("Zum Login", ['account/index'], ['class'=>'btn btn-primary']) ?>
                        </p>
                    </div>
                </div>
                                
                <br/>
        </div>
                
    </article>

