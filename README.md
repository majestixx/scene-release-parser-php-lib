# Warning: Deprecated
There is a improved version of this library.
Use [majestixx/scene-release-parser](https://github.com/majestixx/scene-release-parser)  forked from [thcolin/scene-release-parser](https://github.com/thcolin/scene-release-parser).

# scene-release-parser-php-lib
PHP Library to parse scene release names into their parts.

The library contains two classes: SceneParser and SceneParserGuessr
Scene Parser is splitting the information from scene release dir names and creates an object with easy access to all information.

Example (from sceneParserDemo.php):
```
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
```

For tv shows also the episode and season can be extracted.

SceneParserGuessr works similar, but also provides the methods guessResolution, guessYear and guessLanguage for guessing information that may be missing in the release title.

## Similar projects
- [peterhellberg/release](https://github.com/peterhellberg/release) (Go)
- [danielhusar/movie-title](https://github.com/danielhusar/movie-title) (JavaScript)
- [matiassingers/scene-release](https://github.com/matiassingers/scene-release) (JavaScript)
