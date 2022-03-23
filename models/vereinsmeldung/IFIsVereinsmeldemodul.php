<?php

namespace app\models\vereinsmeldung;

/**
 *
 * @author Mark Worthmann
 */
interface IFIsVereinsmeldemodul {
    
    /**
     * Prueft, ob schon erledigt
     * @return boolean
     */
    public static function isDone($vereinsmeldung_id);
    /**
     * Prueft, ob ein Badge/Hinweis zur Meldung angezeigt werden kann
     * @return boolean|string
     */
    public static function doneError($vereinsmeldung_id);
    
    /**
     * Verhindert, dass das Objekt doppelt geladen wird
     */
    public static function getInstance($vereinsmeldung_id);

    
    
}
