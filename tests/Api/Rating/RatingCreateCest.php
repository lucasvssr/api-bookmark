<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class RatingCreateCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'user' => 'string:path',
            'bookmark' => 'string:path',
            'value' => 'integer',
        ];
    }

    public function anonymousUserCantCreateRating(ApiTester $I): void
    {
        UserFactory::createOne();
        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => 5]);

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function authenticatedUserCanCreateRating(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => 5]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function authenticatedUserCantCreateDoubleRating(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => 5]);

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => 2]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function authenticatedUserCantCreateNegativeRating(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => -5]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function authenticatedUserCantCreateSuperiorRating(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/1', 'bookmark' => '/api/bookmarks/1', 'value' => 15]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function authenticatedUserForbiddenToCreateOtherUsersRatings(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();
        UserFactory::createOne();

        $I->sendPost('/api/ratings', ['user' => '/api/users/2', 'bookmark' => '/api/bookmarks/1', 'value' => 5]);
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanCreateRatingWithoutUserParameter(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);

        BookmarkFactory::createOne();

        $I->sendPost('/api/ratings', ['bookmark' => '/api/bookmarks/1', 'value' => 5]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
