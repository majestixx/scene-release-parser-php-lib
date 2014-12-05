<?php
require_once "SceneParser.php";

$release = new SceneParser("Angriff.der.Urzeitmonster.German.2006.COMPLETE.PAL.DVDR-MOViEiT");

print("\nType: ");
print_r($release->getType()); //Return: movie

print("\nTitle: ");
print_r($release->getTitle()); //Return: Angriff der Urzeitmonster

print("\nLanguage: ");
print_r($release->getLanguage()); //Return: German

print("\nYear: ");
print_r($release->getYear()); //Return: 2006

print("\nResolution: ");
print_r($release->getResolution()); // Is empty as not resolution (like 720p) is given in the name

print("\nSource: ");
print_r($release->getSource()); // Return: DVDR

print("\nDubbed: ");
print_r($release->getDubbed()); // Empty. Not dubbed

print("\nEncoding: ");
print_r($release->getEncoding()); // Empty. Not reencoded

print("\nGroup: ");
print_r($release->getGroup()); // Return: MOViEiT

print("\nAdditional Flags: ");
print_r($release->getAdditionalFlags()); // Return: Array with COMPLETE & PAL
