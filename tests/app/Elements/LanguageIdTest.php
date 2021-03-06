<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2021 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Elements;

use Fisharebest\Webtrees\TestCase;

/**
 * Test harness for the class LanguageId
 *
 * @covers \Fisharebest\Webtrees\Elements\AbstractElement
 * @covers \Fisharebest\Webtrees\Elements\LanguageId
 */
class LanguageIdTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanonical(): void
    {
        $element = new LanguageId('');

        self::assertSame('English', $element->canonical("\t English\t "));
        self::assertSame('Klingon', $element->canonical('kLiNgOn'));
        self::assertSame('Anglo-Saxon', $element->canonical('anglo-saxon'));
        self::assertSame('Catalan_Spn', $element->canonical('CATALAN_SPN'));
    }
}
