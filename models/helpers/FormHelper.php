<?php

/*
 */

namespace app\models\helpers;

use yii\helpers\Url;

/**
 * Description of FormConfigArray
 *
 * @author mwort
 */
class FormHelper {
    public static $lableWeiter;
    public static $prefix;
    public static $formname;//bei dependent-Felder benoetigt
    
    /**
     * Gibt das formConfigArray für en View zurück mit allen Einstellungen
     * Zwingend in activeForm einzubinden, um Validierung korrekt zu ermöglichen
     * (setzt korrekte css-klassen und breiten)
     * @param string $formId [optional | default = 'form'] Id des <form>-tags ist einstellbar,
     * um mehrere unterschiedliche Ids auf einer Seite verwenden zu können
     * @param $isHorizontal [optional | default = true] true = Zweispaltig, false = label und input untereinander
     * @return array
     */
    public static function getConfigArray($formId = "form", $isHorizontal = true){
        return
        [
            'id' => $formId,
            'options'           => ['class' => ''],
             //'layout'            => ($isHorizontal)?'horizontal':'default',
            'successCssClass'   => 'form-text text-success',
            'errorCssClass'     => 'form-text text-danger',
            'fieldConfig'  => [
                //'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'errorOptions' => ['class'=>'form-text text-danger']
                /*
                'horizontalCssClasses' => [
                    'label'     => 'col-sm-3',
                    'wrapper'   => 'col-sm-9',
                    'error'     => '',
                    'hint'      => ''
                ],
                 * 
                 */
            ]
        ];
    }
    
    /**
     * Gibt eine RadioList nicht als radioboxen, sondern als ganze auswählbare
     * Zeile zurück
     * Muss aufgerufen werden mit:
     * $form->field($model, 'vereins_id')->label(false)->radioList($vereine,FormHelper::getRadioListAsSelectableLine($items))
     * Darzustellende Items sollten vorher auf Id => Name gebracht werden
     * Beispiel::find()->select(['name'])->indexBy('id')->column();
     * @return array
     * Wird ausgegeben als:
     *                   <div class="card list-group-item flex-fill p-0">
     *                      <input type="radio">;
     *                      <div class="card-body">
     *                         <h5 class="card-title">Name</h5>
     *                         <a href="" class="stretched-link"></a>
     *                      </div>
     *                   </div>
     * @param string $labelWeiter Label, für den Hinweis zum Weiter-Button nach Auswahl
     */
    public static function getRadioListAsSelectableLine($lableWeiter = 'Weiter'){
        self::$lableWeiter = $lableWeiter;
        return
        [
            'item' => function($index, $label, $name, $checked, $value) {

                $return  = '<div class="card list-group-item flex-fill p-0 radioListAsLine">';
                $return .= '   <input type="radio" id="' . $label.$index . '" name="' . $name . '" value="' . $value . '"'. (($checked)?' checked':'').'>';
                $return .= '   <div class="card-body">';
                $return .= '      <label for="'. $label.$index .'">';
                $return .= '         <h5 class="card-title" id="item-'.$value.'">' . ucwords($label) . '</h5>';
                $return .= '         <small>Ausgewählt, bitte noch unten mit '.self::$lableWeiter.' bestätigen</small>';
                $return .= '      </label>';
                $return .= '   </div>';
                $return .= '</div>';
                
                return $return;
            },
            'unselect' => null,
        ];
       
    }

    /**
     * Gibt eine Radiobox-Auswahl als auswählbare Zeile aus. Abhängig der Auswahl von diesem Feld, wird 
     * eine Url aufgerufen, dessen Ergebnis ein anderes Feld ersetzt.
     * @param array $dependentUrl (route, die an Url::toRoute übergeben wird / ruft Inhalt für das zu ersetzende Feld ab)
     * @param string $targetId Zu ersetzendes Feld (id oder eindeutige css-klasse)
     * @param string $formname Wird als name beim input im per ajax geladenen Targetfeld verwendet)
     * @param string $id_prefix Wird als id beim input als prefix davor gesetzt)
     * @return type
     */
    public static function getRadioListAsSelectableLineWithDependentField(array $dependentUrl,string $targetId, string $formname, string $id_prefix = ""){
        self::$prefix = $id_prefix;
        self::$formname = $formname;

        return
        [
            'item' => function($index, $label, $name, $checked, $value) {

                $return  = '<div class="card list-group-item flex-fill p-0 radioListAsLine">';
                $return .= '   <input type="radio" id="' . self::$prefix.$label.$index . '" name="' . $name . '" value="' . $value . '"'. (($checked)?' checked':'').'>';
                $return .= '   <div class="card-body">';
                $return .= '      <label for="'. self::$prefix.$label.$index .'">';
                $return .= '         <h5 class="card-title" id="item-'.$value.'">' . ucwords($label) . '</h5>';
                $return .= '         <small>Ausgewählt</small>';
                $return .= '      </label>';
                $return .= '   </div>';
                $return .= '</div>';
                
                return $return;
            },
            'unselect' => null,
            'onChange'  => '
                $.get(
                    "' . Url::toRoute($dependentUrl) . '", 
                    {
                        p: $(this).parent().find(\'.radioListAsLine input:checked\').val(),
                        p2: "'.self::$formname.'"
                    },
                    function(res){
                        $("'.$targetId.'").html(res);
                    }
                );
            ',
        ];
       
    }

    /**
     * Zielfeld für dependent-Aufruf, wleches nach dem Ajax-Call gerendert wird
     * @param type $items Items, die als radio-input dargestellt werden sollen key=>value - pair
     * @param type $name Name des input-Feldes
     * @return string
     */
    public static function getDependentFieldAsRadioListAsLine($items, $name, $formname){
        $return = "";
        foreach($items as $key=>$value){
                $return .= '<div class="card list-group-item flex-fill p-0 radioListAsLine">';
                $return .= '   <input type="radio" id="' . $value.$key . '" name="'. $formname. "[". $name ."]" . '" value="' . $key . '"'.'>';
                $return .= '   <div class="card-body">';
                $return .= '      <label for="'. $value.$key .'">';
                $return .= '         <h5 class="card-title" id="item-'.$key.'">' . ucwords($value) . '</h5>';
                $return .= '         <small>Ausgewählt</small>';
                $return .= '      </label>';
                $return .= '   </div>';
                $return .= '</div>';
        }
        
        return $return;
        
    }

    /**
     * Zielfeld für dependent-Aufruf, wleches nach dem Ajax-Call gerendert wird
     * Bei Auswahl wird ein weiteres Feld getriggert
     * @param array $items Items, die als radio-input dargestellt werden sollen key=>value - pair
     * @param string $name Name des input-Feldes
     * @param array $dependentUrl (route, die an Url::toRoute übergeben wird / ruft Inhalt für das zu ersetzende Feld ab)
     * @param string $targetId Zu ersetzendes Feld (id oder eindeutige css-klasse)
     * @param string $formname Wird als name beim input im per ajax geladenen Targetfeld verwendet)
     * @param string $id_prefix Wird als id beim input als prefix davor gesetzt)
     * @return string
     */
    public static function getDependentFieldAsRadioListAsLineWithDependentField($items, $name, array $dependentUrl,string $targetId, string $formname , string $id_prefix = ""){
        $return = "";
        $index  = 1;

        \Yii::debug(json_encode($dependentUrl));
        $onchange = '
        $.get(
            "' . Url::toRoute($dependentUrl) . '", 
            {
                p: $(this).parent().find(\'.radioListAsLine input:checked\').val(),
                p2: "'.$formname.'"
            },
            function(res){
                $("'.$targetId.'").html(res);
            }
        );
        ';


        $return .= '<div class="" onchange="'. htmlspecialchars($onchange).'">';
        foreach($items as $key=>$value){
                $return .= '<div class="card list-group-item flex-fill p-0 radioListAsLine">';
                $return .= '   <input type="radio" id="' . $id_prefix.$value.$key . '" name="' . $formname."[".$name."]" . '" value="' . $key . '">';
                $return .= '   <div class="card-body">';
                $return .= '      <label for="'. $id_prefix.$value.$key .'">';
                $return .= '         <h5 class="card-title" id="item-'.$key.'">' . ucwords($value) . '</h5>';
                $return .= '         <small>Ausgewählt</small>';
                $return .= '      </label>';
                $return .= '   </div>';
                $return .= '</div>';
        }
        $return .= '</div>';
        \Yii::debug(json_encode($return));
        
        return $return;
        
    }
    
    
    /**
     * 
     * @param type $fieldname ID des Feldes unter dem ersetzt werden solls
     * @param type $name Was ausgewählt werden soll
     */
    public static function getDependentDefaultField($fieldname, $name){
        $return  = "";
        $return .= '<div class="form-group required">';
        $return .= '    <div class="" id="'.$fieldname.'">';
        $return .= '        <div class="alert alert-info">';
        $return .= '            Wähle hier bitte eine '.$name.' aus, sobald oben ein anderes Feld gefüllt ist.';
        $return .= '        </div>';
        $return .= '    </div>';
        $return .= '</div>';
        return $return;
        
    }
    
    /**
     * Gibt eine CheckboxList nicht als checkboxen, sondern als ganze auswählbare
     * Zeile zurück
     * Muss aufgerufen werden mit:
     * $form->field($model, 'vereins_id')->label(false)->checkboxList($vereine,FormHelper::getRadioListAsSelectableLine($items))
     * Darzustellende Items sollten vorher auf Id => Name gebracht werden
     * Beispiel::find()->select(['name'])->indexBy('id')->column();
     * @return array
     * Wird ausgegeben als:
     *                   <div class="card list-group-item flex-fill p-0">
     *                      <input type="checkbox">;
     *                      <div class="card-body">
     *                         <h5 class="card-title">Name</h5>
     *                         <a href="" class="stretched-link"></a>
     *                      </div>
     *                   </div>
     * @param string $labelWeiter Label, für den Hinweis zum Weiter-Button nach Auswahl
     */
    public static function getCheckboxListAsSelectableLine($lableWeiter = 'Weiter'){
        self::$lableWeiter = $lableWeiter;
        return
        [
            'itemOptions' => [
                'uncheck' => null
            ],
            'item' => function($index, $label, $name, $checked, $value) {

                $return  = '<div class="card list-group-item flex-fill p-0 radioListAsLine">';
                $return .= '   <input type="checkbox" id="' . $label.$index . '" name="' . $name . '" value="' . $value . '"'. (($checked)?' checked':'').'>';
                $return .= '   <div class="card-body">';
                $return .= '      <label for="'. $label.$index .'">';
                $return .= '         <h5 class="card-title" id="item-'.$value.'">' . ucwords($label) . '</h5>';
                $return .= '         <small>Ausgewählt, bitte noch unten mit '.self::$lableWeiter.' bestätigen</small>';
                $return .= '      </label>';
                $return .= '   </div>';
                $return .= '</div>';
                
                return $return;
            },
            'uncheck' => null,
        ];
       
    }

    
    /**
     * Gibt je Gruppe eine Überschrift und eine untereinander stehende Liste von Checkboxen als Switch aus. 
     * @param array $groups Ein Array mit Objekten, welche die Gruppenobjekte enthalten
     * @param string $groupNameAttribute Attributname, welche den Namen der Gruppe enthält (Überschrift) 
     * @param string $groupItemRelationAttribute Attributname der Relation, welche im $groups-Objekt die Items enthält.
     * Je Item wird dann eine Checkbox ausgegeben
     * @param type $groupItemNameAttribute Attributname, welche den Namen des einzelnen Items/Checkbox enthält (Überschrift)
     * @param type $checked_values Ein Array nur mit den Ids (Values) der Items, welche als checked ausgegeben werden sollen
     * @param type $forminputname Name für das input-Feld
     * @return string HTML
     * Wird ausgegeben als:
     *                   <div class="mb-3">
     *                       <label for="name" class="form-label fw-bold">$groupNameAttribute.</label>
     *                       <div class="form-check form-switch">
     *                           <label>
     *                               <input type="checkbox" name="$groupItemNameAttribute" class="form-check-input" role="switch" checked>
     *                           </label>
     *                       </div>
     *                   </div>
     */
    public static function renderListOfSwitchesWithGroupNames($groups, $groupNameAttribute, $groupItemRelationAttribute, $groupItemNameAttribute, $checked_values,$forminputname )
    {
        $return = "";
        foreach($groups as $group){
            $return.= '
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">'.$group->$groupNameAttribute.'</label>';
            foreach($group->$groupItemRelationAttribute as $item){
                $return.= '
                        <div class="form-check form-switch">
                            <label>
                            '.
                            \yii\bootstrap4\Html::checkbox($forminputname, \yii\helpers\ArrayHelper::isIn($item->id, $checked_values), ['class'=>'form-check-input','role'=>'switch', 'value'=>$item->id, 'id'=>'edit-'.$item->id])
                            .'
                            '.
                            $item->$groupItemNameAttribute
                            .'
                            </label>
                        </div>';
            }
            $return.= '
                    </div>
                    ';
        }
        return $return;
    }
    
    /**
     * Gibt eine untereinander stehende Liste von Checkboxen als Switch aus. 
     * Je Item wird dann eine Checkbox ausgegeben
     * @param array $items
     * @param type $itemNameAttribute Attributname, welche den Namen des einzelnen Items/Checkbox enthält
     * @param type $checked_values Ein Array nur mit den Ids (Values) der Items, welche als checked ausgegeben werden sollen
     * @param type $forminputname Name für das input-Feld
     * @return string HTML
     * Wird ausgegeben als:
     *                   <div class="mb-3">
     *                       <label for="name" class="form-label fw-bold">$itemNameAttribute.</label>
     *                       <div class="form-check form-switch">
     *                           <label>
     *                               <input type="checkbox" name="$itemNameAttribute" class="form-check-input" role="switch" checked>
     *                           </label>
     *                       </div>
     *                   </div>
     */
    public static function renderListOfSwitches($items, $itemNameAttribute, $checked_values, $forminputname )
    {
        
        $return = "";
        $return.= '
                <div class="mb-3">';
        foreach($items as $item){

            $return.= '
                    <div class="form-check form-switch">
                        <label>
                        '.
                        \yii\bootstrap4\Html::checkbox($forminputname, \yii\helpers\ArrayHelper::isIn($item->id, $checked_values), ['class'=>'form-check-input','role'=>'switch', 'value'=>$item->id, 'id'=>'edit-'.$item->id])
                        .'
                        '.
                        $item->$itemNameAttribute
                        .'
                        </label>
                    </div>';
        }
        $return.= '
                </div>
                ';
        return $return;
    }
    
}
