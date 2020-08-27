<?php

namespace PHPSTORM_META {
    registerArgumentsSet(
        'characterSets',
        \rikudou\EuQrPayment\Sepa\CharacterSet::UTF_8,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_1,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_2,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_4,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_5,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_7,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_10,
        \rikudou\EuQrPayment\Sepa\CharacterSet::ISO_8859_15
    );

    expectedReturnValues(
        \rikudou\EuQrPayment\QrPayment::getCharacterSet(),
        argumentsSet('characterSets')
    );

    expectedArguments(
        \rikudou\EuQrPayment\QrPayment::setCharacterSet(),
        0,
        argumentsSet('characterSets')
    );
}
