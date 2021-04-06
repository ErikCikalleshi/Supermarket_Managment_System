# Cikalleshi_SNMP
Informatik: Programmierung mit HTML, PHP, JavaScript, PDO und MySQL

## Introduction

Diese Website soll das Verwaltungssystem eines Supermarktes simulieren. Die Seite wurde mit HTML, PHP, JavaScript, PDO und MySQL programmiert.


## Features

Auf dieser Website kann man sich einen Account herstellen (sollte später für Kunden gedacht sein und den Online-Shop). Wenn man sich als Admin anmeldet, kann man fast ein ganzes Supermarket verwalten, wie z.B. neue Produkte hinzufüge, nachschauen wie viel Produkte noch in einem Lager übrig sind usw. Zudem hat man als Home-Seite ein Dashboard. 


## Running the Program

Die jar-Datei sollte mit dem folgenden Befehl ausgeführt werden:

```
java --module-path {PATH_TO_FX_NUMBER/lib} --add-modules javafx.controls,javafx.fxml,javafx.base,javafx.graphics,javafx.web,javafx.swing -jar {PATH_TO_JAR}
```
**Reminder: JavaFx 15 und JDK 14 muss installiert sein**

Um nachzuschauen, welche Version man auf dem Rechner installiert hat, führen Sie folgenden Befehl aus:
```
java -version
```
## How to use

Man muss nur das gewünschte Subnet und die Community eingeben. Die `Methode` ist standardmäsßig auf `Basic` eingestellt.

![Scanning for Network](src/example.png)

### Features

#### Input

![Scan](src/1Schreibweise.png)
![Scan](src/2Schreibweise.png)
![Scan](src/3Schreibweise.png)

#### Load Own Files

![File](src/File.png)

#### Method

![File](src/SelectGet.png)

#### Mibs or Oids

![Mibs](src/ShowMib.gif)


## Trap Listener

Um den Listener zu starten müssen sie auf `Start/Stop` klicken und den gewünschten Port eingeben.
![Trap](src/GetTrap.png)

Leider auf Windows sind Traps schwerer weiterzuleiten, als in Linux. Aber glücklicherweise kann man mit den Tool von [iReasoning](https://www.ireasoning.com/) Traps weiterleiten. 

### Send Trap

Unter `Tools` kann man den `Trap Sender` finden.

![SendTrap](src/SendTrap.png)
