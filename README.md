# PHP Sorting Resource File Script

1. reads a translation file,
2. alphabetically sorts (A-Z) the translations and
3. creates a new file that contains a sorted list of all translations while mainaining the comments either single-line or multi-line.

Some special cases being handled in the new file:
1. Empty lines are ignored
2. File will end with an empty line
3. Extra spaces are removed from both the Keys and translations
4. If duplicate keys are present it will consider the last one


by,
Hasan Hameed
