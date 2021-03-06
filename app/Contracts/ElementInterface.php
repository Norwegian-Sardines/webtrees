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

namespace Fisharebest\Webtrees\Contracts;

use Fisharebest\Webtrees\Tree;

/**
 * A GEDCOM element is a tag/primitive in a GEDCOM file.
 */
interface ElementInterface
{
    /**
     * Convert a value to a canonical form.
     *
     * @param string $value
     *
     * @return string
     */
    public function canonical(string $value): string;

    /**
     * Create a default value for this element.
     *
     * @param Tree $tree
     *
     * @return string
     */
    public function default(Tree $tree): string;

    /**
     * An edit control for this data.
     *
     * @param string $id
     * @param string $name
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function edit(string $id, string $name, string $value, Tree $tree): string;

    /**
     * Escape @ signs in a GEDCOM export.
     *
     * @param string $value
     *
     * @return string
     */
    public function escape(string $value): string;

    /**
     * Name for this GEDCOM primitive.
     *
     * @return string
     */
    public function label(): string;

    /**
     * Create a label/value pair for this element.
     *
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function labelValue(string $value, Tree $tree): string;

    /**
     * @param Tree $tree
     *
     * @return array<string,string>
     */
    public function subtags(Tree $tree): array;

    /**
     * Display the value of this type of element.
     *
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function value(string $value, Tree $tree): string;

    /**
     * A list of controlled values for this element
     *
     * @return array<int|string,string>
     */
    public function values(): array;
}
