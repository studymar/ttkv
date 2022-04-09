<?php

namespace app\models\vereinsmeldung\teams;

use Yii;
use app\models\vereinsmeldung\teams\Ligazusammenstellung;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use app\models\vereinsmeldung\teams\Team;

/**
 * Export Ligeneinteilung
 *
 */
class ExcelExportLigeneinteilung extends \yii\base\Model
{

    public static function getLigeneinteilung($season, $altersbereich, $ligeneinteilung) {
        $writer = WriterEntityFactory::createXLSXWriter();
        // $writer = WriterEntityFactory::createCSVWriter();

        //$writer->openToFile($filePath); // write data to a file or to a PHP stream
        $writer->openToBrowser('Ligeneinteilung-'.$altersbereich->name.'.xlsx'); // stream data directly to the browser        

        foreach($ligeneinteilung as $altersklasse=>$ligen){
            $emptyCell  = [WriterEntityFactory::createCell("")];
            $emptyRow   = WriterEntityFactory::createRow($emptyCell);
            $writer->addRow($emptyRow);//empty row
            
            $cells = [
                WriterEntityFactory::createCell("Altersklasse:"),
                WriterEntityFactory::createCell($altersklasse),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            foreach($ligen as $liga=>$teams){
                $emptyCell  = [WriterEntityFactory::createCell("")];
                $emptyRow   = WriterEntityFactory::createRow($emptyCell);
                $writer->addRow($emptyRow);//empty row

                //headline
                $cells = [
                    WriterEntityFactory::createCell($liga)
                ];
                $singleRow = WriterEntityFactory::createRow($cells);
                $writer->addRow($singleRow);

                //teams
                //keine Teams?
                if(!count($teams)){
                    $cells = [
                        WriterEntityFactory::createCell("Keine Meldung")
                    ];
                    $singleRow = WriterEntityFactory::createRow($cells);
                    $writer->addRow($singleRow);
                }
                else {
                    //headline-Zeile
                    $cells = [
                        WriterEntityFactory::createCell("Nr"),
                        WriterEntityFactory::createCell("Verein"),
                        WriterEntityFactory::createCell("Heimtage"),
                    ];
                    if($teams[0]->altersklasse->altersbereich->askweeks){
                        $cells[] = WriterEntityFactory::createCell("Wunschwochen");
                    }
                    if($teams[0]->liga->askregional){
                        $cells[] = WriterEntityFactory::createCell("Regio Wunsch");
                    }
                    $cells[] = WriterEntityFactory::createCell("Pokal");

                    $singleRow = WriterEntityFactory::createRow($cells);
                    $writer->addRow($singleRow);
                    //Teamzeilen
                    $i=1; 
                    foreach($teams as $team){
                        $regional = Liga::$regional;
                        $cells = [
                            WriterEntityFactory::createCell($i++),
                            WriterEntityFactory::createCell($team->vereinsmeldungTeams->vereinsmeldung->verein->name." ".$team->number),
                            WriterEntityFactory::createCell($team->heimspieltage),
                        ];
                        if($team->altersklasse->altersbereich->askweeks){
                            $cells[] = WriterEntityFactory::createCell($team->getWeeksName());
                        }
                        if($team->liga->askregional){ 
                            $cells[] = WriterEntityFactory::createCell(($team->regional)? $regional[$team->regional] : '');
                        }
                        $cells[] = WriterEntityFactory::createCell(($team->pokalteilnahme)?'Ja':'Nein');

                        $singleRow = WriterEntityFactory::createRow($cells);
                        $writer->addRow($singleRow);
                    }

                }
            }
        }        
        
        $writer->close();        
        
    }
    
    
}
