<?php

declare(strict_types=1);

namespace VeeWee\Xml\Writer\Builder;

use Closure;
use Generator;
use XMLWriter;

/**
 * @param list<(callable(XMLWriter): Generator<bool>)> $configurators
 *
 * @return Closure(XMLWriter): Generator<bool>
 */
function cdata(callable ...$configurators): Closure
{
    return
        /**
         * @return Generator<bool>
         */
        static function (XMLWriter $writer) use ($configurators): Generator {
            yield $writer->startCdata();
            foreach ($configurators as $configurator) {
                yield from $configurator($writer);
            }

            yield $writer->endCdata();
        };
}
