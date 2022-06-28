
To load Fixtures:
Vorraussetzung: 
XXXFixture - Classes unter tests\unit\fixtures
Fixture-Daten unter tests\unit\fixtures\data
//Dateien liegen unter dem unit verzeichnis

yii fixture/load "*"
yii fixture/unload "*"

To Start Tests:
vendor\bin\codecept run
oder vendor\bin\codecept run unit //nur für unit-tests\unit\fixtures
oder vendor\bin\codecept run acceptance LoginACest

Vorraussetzung:
XXXFixture - Classes unter tests\fixtures
Fixture-Daten unter tests\_data


acceptance-tests:
Selenium installieren und starten mit einem der folgenden Befehle (war vermutlich der dritte):
(vor dem Starten von Selenium, den Ordner, wo die exe drin ist in path-Variable ergänzen).
java -jar -Dwebdriver.gecko.driver=\tests\geckodriver.exe tests\selenium-server-4.1.1.jar
java -jar -Dwebdriver.chrome.driver=\tests\chromedriver.exe selenium-server-4.1.1.jar standalone

//selenium-server-4.1.1.jar -Dwebdriver.gecko.driver=\tests\geckodriver.exe standalone
//oder
//selenium-server-4.1.1.jar -Dwebdriver.chrome.driver=\tests\chromedriver.exe standalone
//oder
selenium-server-4.1.1.jar standalone
