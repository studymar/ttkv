<?php
/* 
 * Vereinsmeldungadmin Ligeneinteilung
 * @param $season
 */

use yii\helpers\Url;

?>


    <article>
        <!-- Vereinsmeldung Übersicht -->
        <h2>Vereinsmeldung</h2>
        <div>
            <div class="" id="intro">
                <div>
                    Vereinsmeldung:
                    <div class="fw-bold"><?= $season->name ?></div>
                </div>
            </div>
            <hr/>
        </div>
        
        <div>
            <h3>Bezirksliga</h3>
            <hr/>
            <table>
                
            </table>
        </div>

        <div>
            <h3>Bezirksliga</h3>
            <hr/>
            <table>
                
            </table>
        </div>

        
        <br/><br/>
        <div class="d-flex justify-content-between p-1">
            <div class="d-flex justify-content-between p-1">
                <div class="form-group">
                    <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
                </div>
            </div>
        </div>
        
    </article>

