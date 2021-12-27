# GS1-insbou-order-converter

This package can convert order data to GS1 INSBOU003-structured XML files.

## Spelling mistakes and irregularities

Beware, there are a few spelling mistakes and irregularities of the production-implementation when compared to the standards documentation. 
They are, unfortunately, part of the implementation of some vendors - but not all.
For this reason, the ```isValid``` and ```toXML``` functions can now cope with these deviations. 
They may be fixed in the implementation of the INSBOU003's successor: SALES005.

### Orderline

Orderline has a property `LineIdentification`, which is spelled with an extra `t` : `LineIdenti`**t**`fication`.

### ContactInformation

There are two classes that contain a `ContactInformation` property: `Buyer` and `DeliveryParty`.
However, in the `DeliveryParty` class, this is spelled as its Dutch translation: `Contactgegevens`.

Additionally, the `DeliveryParty`'s `Contactgegevens` supposedly may not contain an `Emailaddress` whereas the `Buyer`'s `ContactInformation` may.
This is also not the case, both may have an `EmailAddress`.

### DeliveryParty

#### - GLN

Furthermore, the `DeliveryParty` class is the only `Party` class that cannot contain a `GLN`.
For this reason, the functionality of the `Party`-class is split, and the GLN was moved to the `GLNParty`-class that extends the `Party`-class.
The `DeliveryParty`-class is the only `Party` that does *not* extend the `GLNParty` but instead extends the `Party`-class.

#### - LocationDescription

According to the INSBOU003 standard, the class `DeliveryParty` should have a property `LocationDescription`. 
Unfortunately this is not the case.

## Public Examples:

 - https://profitdownload.afas.nl/download/help_docs/Oosterberg.txt

