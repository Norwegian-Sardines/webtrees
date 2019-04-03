<?php
/**
 * webtrees: online genealogy
 * Copyright (C) 2019 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Fisharebest\Webtrees\Statistics\Repository;

use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\Carbon;
use Fisharebest\Webtrees\Contracts\UserInterface;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Services\UserService;
use Fisharebest\Webtrees\Statistics\Repository\Interfaces\LatestUserRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

/**
 * A repository providing methods for latest user related statistics.
 */
class LatestUserRepository implements LatestUserRepositoryInterface
{
    /**
     * @var UserService
     */
    private $user_service;

    /**
     * LatestUserRepository constructor.
     *
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * @inheritDoc
     */
    public function latestUserId(): string
    {
        return (string) $this->latestUserQuery()->id();
    }

    /**
     * Find the newest user on the site.
     * If no user has registered (i.e. all created by the admin), then
     * return the current user.
     *
     * @return UserInterface
     */
    private function latestUserQuery(): UserInterface
    {
        static $user;

        if ($user instanceof UserInterface) {
            return $user;
        }

        $user_id = DB::table('user as u')
            ->select(['u.user_id'])
            ->leftJoin('user_setting as us', static function (JoinClause $join): void {
                $join->on(static function (Builder $query): void {
                    $query->whereColumn('u.user_id', '=', 'us.user_id')
                        ->where('us.setting_name', '=', 'reg_timestamp');
                });
            })
            ->orderByDesc('us.setting_value')
            ->value('user_id');

        $user = $this->user_service->find($user_id) ?? Auth::user();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function latestUserName(): string
    {
        return e($this->latestUserQuery()->userName());
    }

    /**
     * @inheritDoc
     */
    public function latestUserFullName(): string
    {
        return e($this->latestUserQuery()->realName());
    }

    /**
     * @inheritDoc
     */
    public function latestUserRegDate(string $format = null): string
    {
        $format    = $format ?? I18N::dateFormat();
        $user      = $this->latestUserQuery();
        $timestamp = (int) $user->getPreference('reg_timestamp');

        return Carbon::createFromTimestamp($timestamp)->format(strtr($format, ['%' => '']));
    }

    /**
     * @inheritDoc
     */
    public function latestUserRegTime(string $format = null): string
    {
        $format = $format ?? str_replace('%', '', I18N::timeFormat());
        $user   = $this->latestUserQuery();

        return date($format, (int) $user->getPreference('reg_timestamp'));
    }

    /**
     * @inheritDoc
     */
    public function latestUserLoggedin(string $yes = null, string $no = null): string
    {
        $yes  = $yes ?? I18N::translate('yes');
        $no   = $no ?? I18N::translate('no');
        $user = $this->latestUserQuery();

        $is_logged_in = DB::table('session')
            ->selectRaw('1')
            ->where('user_id', '=', $user->id())
            ->first();

        return $is_logged_in ? $yes : $no;
    }
}
