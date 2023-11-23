# phpgen
phpgen might become a simple yet powerfull PHP source code generator.

## TODO
- Printer abstraction. Allows to print builders depending on some configuration (indentation, etc). Inherit printer from parent nodes.
- Locking fields. Allows to lock a certain field (printer for example) to disable deep-node mutations.
- Printer targets. Allow to print same builder instance differently depending on targeting PHP version. Target version defaults to currently used version (`phpversion()`). 
