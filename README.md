# Cikalleshi_SNMP
Informatik: Programmierung mit HTML, PHP, JavaScript, PDO und MySQL

## Introduction

Diese Website soll das Verwaltungssystem eines Supermarktes simulieren. Die Seite wurde mit HTML, PHP, JavaScript, PDO und MySQL programmiert.


## Features

Sie können auf dieser Seite ein Konto anlegen (sollte später für Kunden und den Online-Shop sein). Wenn Sie sich als Administrator anmelden, können Sie fast alles in einem Supermarkt verwalten, z. B. neue Produkte hinzufügen, prüfen, wie viele Produkte noch auf Lager sind, usw. Außerdem hat man ein Dashboard als Startseite. 

## Current Features
* Sig-in and Login
* Dashboard with Charts
* Managment 
  * Employee
  * Item
  * Stock
  * Sales
  * Client
* Edit and delete tables
* Change Password
* Log Out

## ER-Diagram

![Er-Diagram]()

## How to use

Man muss nur das gewünschte Subnet und die Community eingeben. Die `Methode` ist standardmäsßig auf `Basic` eingestellt.

![Scanning for Network](er_modell.png)


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
