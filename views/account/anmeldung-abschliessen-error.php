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
                            <li class="list-group-item flex-fill list-group-item-secondary">Anmeldung bestätigen</li>
                        </ul>
                    </div>
                    
                    <div class="">
                        <p>
                            Ups...das hat nicht funktioniert 
                            <br>
                        </p>
                        <div class="alert alert-danger">
                            <?= $model->getErrors('validationtoken')[0] ?>
                        </div>
                    </div>
                </div>
                                
                <br/>
        </div>
                
    </article>

